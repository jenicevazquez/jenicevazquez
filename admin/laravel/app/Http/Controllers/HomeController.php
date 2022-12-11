<?php


namespace App\Http\Controllers;

use App\Http\Requests;
use App\Libraries\Repositories\GeneralRepository;
use App\Models\Auditoria;
use App\Models\Cfdi;
use App\Models\Cuenta;
use App\Models\Licencia;
use App\Models\Nomina;
use App\Models\Pedimento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Excel;
use App\GenericClass;
use Response;
/**
 * Class HomeController
 * @package App\Http\Controllers
 */
class HomeController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        if(!Auth::guest())
            GenericClass::setConnectionByLicencia(Session::get("workspace"));
    }

    public function index()
    {
        return view('home');
    }
    public function indexSCAN()
    {
        DB::connection("sitce_tarifa")->table("user_log")->whereRaw("last_activity<=DATEADD(DAY,-1,getdate()) AND activo=1")->update(array(
            "activo"=>0
        ));
        $activos = DB::connection("sitce_tarifa")->table("user_log")->where("activo","1")->count();
        $demo = DB::connection("sitce_tarifa")->table("users")->where("licencia_id","1008")->count();
        $estudiante = DB::connection("sitce_tarifa")->table("users")->where("licencia_id","1009")->count();
        $licencia = Licencia::where("sistema",3)->where("id","!=","1008")->where("id","!=","1009")->count();
        $cantidad = Cuenta::where("tipo",1)->where("concepto","VENTAS SCAN")->sum("cantidad");
        return view('homeSCAN')
            ->with("demo",$demo)
            ->with("estudiantes",$estudiante)
            ->with("licencias",$licencia)
            ->with("cantidad",$cantidad)
            ->with("activos",$activos);
    }


    function expediente(Request $request){
        $input = $request->all();
        $connection = DB::connection("expediente");


        $anios = $connection->table("pedimentos")->where("licencia", Auth::user()->licencia_id)
            ->where(DB::raw("year(fechapago)"),">",1900)->distinct()->select(DB::raw("year(fechapago) as anio"))
            ->orderby(DB::raw("year(fechapago)"),"desc")->lists("anio");

        isset($input["anio"]) ? $fecha2 = $input["anio"] : $fecha2 = 2018;
        $array = [];
        foreach ($anios as $anio){
            $array[$anio] = $anio;
        }

        $licencia = Auth::user()->licencia_id;
        #region PorAgentes
        $query = $connection->table("pedimentos");
        $query->where("pedimentos.licencia",$licencia)->whereBetween("pedimentos.fechapago",[$fecha2, ($fecha2 +1)]);

        $data = $query->select(DB::raw("ISNULL(pedimentos.agente,'No especificado') as label"),DB::raw("count(*) as valor"))
            ->groupby(DB::raw("ISNULL(pedimentos.agente,'No especificado')"))->get();
        $datos[] = $this->keyAndValue($data);
        #endregion

        #region PorClave
        $query = $connection->table("pedimentos");
        $query->where("pedimentos.licencia",$licencia)->whereBetween("pedimentos.fechapago",[$fecha2, ($fecha2 +1)]);
        $data = $query->select(DB::raw("ISNULL(clave,'No especificado') as label"),DB::raw("count(*) as valor"))
            ->groupby(DB::raw("ISNULL(clave,'No especificado')"))->get();
        $datos[] = $this->keyAndValue($data);
        #endregion

        #region PorOperacion
        $query = $connection->table("pedimentos");
        $query->where("pedimentos.licencia",$licencia)->whereBetween("pedimentos.fechapago",[$fecha2, ($fecha2 +1)]);
        $data = $query->select(DB::raw("ISNULL(CASE operacion WHEN 1 THEN 'Importación' ELSE 'Exportación' END,'No especificado') as label"),DB::raw("count(*) as valor"))
            ->groupby(DB::raw("ISNULL(CASE operacion WHEN 1 THEN 'Importación' ELSE 'Exportación' END,'No especificado')"))->get();
        $datos[] = $this->keyAndValue($data);
        #endregion

        #region PorAduana
        $query = $connection->table("pedimentos");
        $query->where("pedimentos.licencia",$licencia)->whereBetween("pedimentos.fechapago",[$fecha2, ($fecha2 +1)]);
        $data = $query->select(DB::raw("ISNULL(pedimentos.seccion+' - '+SUBSTRING(aduanas.nombre,0,21),'No especificado') AS label"),DB::raw("count(*) as valor"))
            ->leftjoin("aduanas","aduanas.seccion","=","pedimentos.seccion")
            ->groupby(DB::raw("ISNULL(pedimentos.seccion+' - '+SUBSTRING(aduanas.nombre,0,21),'No especificado')"))->get();

        $datos[] = $this->keyAndValue($data);
        #endregion

        #region PedimentosCompletos
        $query = $connection->table("pedimentos");
        $query->where("pedimentos.licencia",$licencia)->whereBetween("pedimentos.fechapago",[$fecha2, ($fecha2 +1)]);
        $data = $query->select(DB::raw("ISNULL(porcentaje,0) as label"),DB::raw("count(*) as valor"))->groupby(DB::raw("ISNULL(porcentaje,0)"))->get();

        $datos[] = $this->keyAndValue($data);
        #endregion

        #region Rojos
        $query = $connection->table("rojos");
        $query->where("rojos.licencia",$licencia)->whereBetween("pedimentos.fechapago",[$fecha2, ($fecha2 +1)])->leftjoin("pedimentos","pedimentos.id","=","rojos.idpedimento");
        $data = $query->select(DB::RAW("(CASE estado WHEN 310 THEN 'Rojo' WHEN 320 THEN 'Verde' ELSE 'En investigacion' END ) as label"),DB::raw("count(*) as valor"))
            ->groupby(DB::RAW("(CASE estado WHEN 310 THEN 'Rojo' WHEN 320 THEN 'Verde' ELSE 'En investigacion' END )"))->get();

        $datos[] = $this->keyAndValue($data);
        #endregion

        if(!isset($input["medio"]) || $input["medio"]=="0"){
            $recientes = Pedimento::where("licencia",$licencia)->orderby("created_at","desc")->take(30)->get();

        }
        else{
            $recientes = Pedimento::where("licencia",$licencia)->whereRaw("created_by like '%".$input["medio"]."%'")->orderby("created_at","desc")->take(30)->get();

        }


        return view('expediente.panel')->with("datos",$datos)->with("anios",$array)->with("q",$input)->with("recientes",$recientes);
    }
    function keyAndValue($results){
        $keys = [];
        $values = [];
        foreach ($results as $result) {
            foreach ($result as $i => $r){
                if($i=="label")
                    $keys[] = $r;
                else if($i=="valor")
                    $values[] = $r;
            }
        }
        return ["labels"=>$keys,"data"=>$values];
    }
    function reportes(){
        return view("expediente.reportes.index");
    }
    function misfacturas(){
        $registros = Nomina::where("usuario",Auth::user()->id)->orderby("serie")->get();
        $total = Nomina::where("usuario",Auth::user()->id)->sum("cantidad");
        return view("misfacturas")->with("registros",$registros)->with("total",$total);
    }
    public function post_upload(Request $request){
        if($request->hasFile('file')) {
            $file = $request->file('file');
            $extension= $file->getClientOriginalExtension();
            $directory = public_path() . '/uploads';
            $filename = sha1(time() . time()) . ".{$extension}";
            $upload_success = $file->move($directory,$filename);
            if ($upload_success) {
                $result = file_get_contents($directory . "/" . $filename);
                $result = str_replace('cfdi:', '', $result);
                $result = str_replace('nomina12:', '', $result);
                $result = str_replace('tfd:', '', $result);
                $xml = simplexml_load_string($result);
                $serie = (string)$xml["Serie"];

                $percepciones = $xml->Complemento->Nomina->Deducciones;
                foreach ($percepciones->Deduccion as $percepcion) {
                    if ($percepcion["TipoDeduccion"] == "004") {
                        $valor = (string)$percepcion["Importe"];
                        Nomina::updateOrCreate([
                            "usuario" => Auth::user()->id,
                            "serie" => $serie
                        ], [
                            "cantidad" => $valor
                        ]);
                    }
                }
                return Response::json('success', 200);
            } else {
                return Response::json('error', 400);
            }
        }
    }
    public function auditoria(){
        //1 son los datos del sat
        //2 datos autocam
        $folder = "C:\autocam";

        $archivos = scandir($folder);
        foreach ($archivos as $archivo){
            if($archivo!="."&&$archivo!=".."){
                $partes = explode(".",$archivo);
                list($tipo,$clave) = explode("_",$partes[0]);
                Auditoria::where("tipo",$tipo)->where("clave",$clave)->delete();
                $file = $folder."\\".$archivo;
                $content = \Excel::load($file, null, 'ISO-8859-1')->get()->toArray();

                foreach ($content as $row){

                    if(isset($row["fecha1"]) && $row["fecha1"]!=null) {
                        try {

                            Auditoria::customUpdateOrCreate([
                                "identificacion" => $row["identificacion1"]
                                , "clave" => $clave
                                , "tipo" => $tipo
                            ], [
                                "valor1" => DB::raw("valor1+" . $row["valor1"])
                                , "iva1" => DB::raw("iva1+" . $row["iva1"])
                                , "ieps1" => DB::raw("ieps1+" . $row["ieps1"])
                            ], [
                                "fecha" => $row["fecha1"]
                                ,"valor1" => $row["valor1"]
                                , "iva1" => $row["iva1"]
                                , "ieps1" => $row["ieps1"]
                            ]);
                        } catch (\Exception $e) {
                            dd($e,$row);
                        }
                    }
                }
                foreach ($content as $row){
                    try {
                        if(isset($row["identificacion2"])) {
                            Auditoria::where([
                                "identificacion" => $row["identificacion2"]
                                , "clave" => $clave
                                , "tipo" => $tipo
                            ])->update([
                                "valor2" => DB::raw("valor2+" . $row["valor2"])
                                , "iva2" => DB::raw("iva2+" . $row["iva2"])
                                , "ieps2" => DB::raw("ieps2+" . $row["ieps2"])
                            ]);
                        }
                    } catch (\Exception $e) {
                        dd($e,$row);
                    }
                }
                foreach ($content as $row){
                    try {
                        if(isset($row["identificacion3"])) {
                            Auditoria::where([
                                "identificacion" => $row["identificacion3"]
                                , "clave" => $clave
                                , "tipo" => $tipo
                            ])->update([
                                "valor2" => DB::raw("valor2+" . $row["valor3"])
                                , "iva2" => DB::raw("iva2+" . $row["iva3"])
                                , "ieps2" => DB::raw("ieps2+" . $row["ieps3"])
                            ]);
                        }
                    } catch (\Exception $e) {
                        dd($e,$row);
                    }
                }
                $registros = Auditoria::where("tipo",$tipo)->where("clave",$clave)->get();
                foreach ($registros as $registro){

                    $registro->fill(array(
                        "dif"=>DB::raw("valor1-valor2"),
                        "difiva"=>DB::raw("iva1-iva2"),
                        "difieps"=>DB::raw("ieps1-ieps2")
                    ))->save();
                }
                echo "terminado";
            }
        }
    }

}