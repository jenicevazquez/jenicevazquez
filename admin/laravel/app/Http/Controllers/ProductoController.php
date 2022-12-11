<?php namespace App\Http\Controllers;

use App\GenericClass;
use App\Models\Admin\Licencia;
use App\Models\CFDI\Cliente;
use App\Models\Cfdi\Producto;
use App\Models\cfdi40\CClaveProdServ;
use App\Models\cfdi40\CClaveUnidad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

use Response;

class ProductoController extends Controller
{
    public function __construct()
    {

        $this->middleware('auth');
        if(!Auth::guest())
            GenericClass::setConnectionByLicencia(Session::get("workspace"));
    }
    function index(){
        return view("productos.index");
    }
    function create(){
        return view("productos.create");
    }
    function show(){

    }
    function datapanel(){

        $productos = Producto::orderby("CodigoMercanciaProducto")->paginate(1000);
        return view("productos.datapanel")->with("registros",$productos);
    }
    function subirArchivo(Request $request){
        if($request->hasFile('archivoProducto')){
            set_time_limit(0);
            $file = $request->file('archivoProducto');
            $nombre = $file->getClientOriginalName();
            $upload = GenericClass::storage()."\\temp";
            $file->move($upload,$nombre);
            $contents = file_get_contents($upload."\\".$nombre);
            $lines = explode(PHP_EOL,$contents);
            foreach ($lines as $line){
                $fields = explode("|",$line);
                if($fields[0]=="551"){
                    Producto::firstOrCreate([
                        "Fraccion"=>$fields[2]
                        ,"SubdivisionFraccion"=>$fields[4]
                        ,"DescripcionMercancia"=>$fields[5]
                        ,"PrecioUnitario"=>$fields[6]
                        ,"UnidadMedidaComercial"=>$fields[11]
                    ]);
                }
            }
        }
    }
    function subirArchivo2(Request $request){
        if($request->hasFile('archivoProducto2')){
            set_time_limit(0);
            $file = $request->file('archivoProducto2');
            $nombre = $file->getClientOriginalName();
            $upload = GenericClass::storage()."\\temp";
            $file->move($upload,$nombre);
            $contents = file_get_contents($upload."\\".$nombre);
            $lines = explode(PHP_EOL,$contents);
            foreach ($lines as $line){
                $fields = explode("|",$line);
                if($fields[0]=="551"){
                    Producto::firstOrCreate([
                        "Fraccion"=>$fields[1]
                        ,"DescripcionMercancia"=>$fields[2]
                        ,"PrecioUnitario"=>round($fields[4]/$fields[5],2)
                        ,"UnidadMedidaComercial"=>$fields[6]
                    ]);
                }
            }
        }
    }
    function borrarProducto(Request $request){
        $input = $request->all();
        try {
            Producto::where("id", $input["id"])->delete();
            return response()->json("Los datos se actualizaron correctamente",200);
        }catch (\Exception $e){
            return response()->json("[".$e->getLine()."] ".$e->getMessage(),500);
        }
    }
    function guardaProducto(Request $request){
        $input = $request->all();
        $input["PrecioUnitario"] =  $input["PrecioUnitario"]==""? 0.00: $input["PrecioUnitario"];
        try{
            if($input["id"]>0){
                $id = $input["id"];
                unset($input["id"]);
                unset($input["_token"]);
                Producto::where("id",$id)->update($input);
            }
            else{
                Producto::create($input);
            }

            return response()->json("Los datos se actualizaron correctamente",200);
        }
        catch (\Exception $e){
            return response()->json("[".$e->getLine()."] ".$e->getMessage(),500);
        }
    }
    function getProducto(Request $request){
        $input = $request->all();
        return Producto::where("CodigoMercanciaProducto",$input["codigo"])->first();
    }
    function traerProductos(Request $request){
        try {
            $input = $request->all();
            $rfc = GenericClass::empresa()->Rfc;
            $conexion = DB::connection("admin")->table("conexiones")->where("clave", Session::get("workspace"))->where("sistema", 2)->first();
            GenericClass::setDinamico($conexion);
            $productos = DB::connection("dinamico")->table("cfdi_conceptos")
                ->leftjoin("cfdi_metadatas","cfdi_metadatas.cfdi_id","=","cfdi_conceptos.cfdi_id")
                ->where("RfcEmisor",$rfc)->where("Estatus","1")->distinct()->get();
            foreach ($productos as $producto) {
                $cclaveprod = CClaveProdServ::select(DB::raw("c_claveprodserv + ' - ' + descripcion as text"),DB::raw("c_claveprodserv as id"))
                    ->whereRaw("c_claveprodserv = '" . $producto->ClaveProvServ . "'")->first();
                $cclaveunidad = CClaveUnidad::select(DB::raw("c_claveunidad + ' - ' + nombre as text"),DB::raw("c_claveunidad + ' - ' + nombre as id"))
                    ->whereRaw("c_claveunidad = '" . $producto->ClaveUnidad . "'")->first();
                Producto::firstOrCreate([
                    "DescripcionMercancia"=>$producto->Descripcion,
                    "PrecioUnitario"=>$producto->ValorUnitario,
                    "Unidad"=>$producto->Unidad,
                    "claveProducto"=>$cclaveprod->text,
                    "ClaveUnidad"=>$cclaveunidad->text
                ]);
            }
            return response()->json("Los datos se actualizaron correctamente",200);
        }
        catch (\Exception $e){
            return response()->json("[".$e->getLine()."] ".$e->getMessage(),500);
        }
    }


}