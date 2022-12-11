<?php namespace App\Http\Controllers;

use App\GenericClass;
use App\Models\CFDI\CfdiSerie;
use App\Models\Cfdi\Empresa;
use App\Models\CFDI\Serie;
use App\Models\CFDI\Certificado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Response;

class EmpresaController extends Controller
{
    public function __construct()
    {

        $this->middleware('auth');
        if(!Auth::guest())
            GenericClass::setConnectionByLicencia(Session::get("workspace"));
    }
    function index(){
        return view("empresa.index");
    }
    function guardarDatosEmisor(Request $request){
        $input = $request->all();
        try{
           $empresa = Empresa::first();
           if($empresa) {
               $empresa->fill($input)->save();
           }
           else{
               Empresa::create($input);
           }
            return response()->json("Los datos se actualizaron correctamente",200);
        }
        catch (\Exception $e){
            return response()->json("[".$e->getLine()."] ".$e->getMessage(),500);
        }
    }
    function setFolio(Request $request){
        $input = $request->all();
        try{
            if($input["id"]>0){
                $serie0 = Serie::where("id", $input["id"])->first();
                $serie = Serie::where("serie", $serie0->serie)->first();
                $serie2 = CfdiSerie::where("serie", $serie->serie)->orderby("id", "desc")->first();
                if (!$serie && !$serie2) {
                    Serie::create($input);
                    return response()->json("La serie se creó correctamente", 200);
                } else if ($serie && !$serie2) {
                    Serie::where("id", $input["id"])->update(array("folio" => $input["folio"],"serie" => $input["serie"], "tipoComprobante" => $input["tipoComprobante"]));
                    return response()->json("La serie se actualizó correctamente", 200);
                } else if (!$serie && $serie2) {
                    if ($input["folio"] > $serie2->folio) {
                        Serie::create($input);
                        return response()->json("La serie se creó correctamente", 200);
                    } else {
                        return response()->json("Hay una factura generada con la serie " . $serie2->serie . " y folio " . $serie2->folio, 500);
                    }
                } else if ($serie && $serie2) {
                    if ($input["folio"] > $serie2->folio) {
                        Serie::where("id", $input["id"])->update(array("folio" => $input["folio"],"serie" => $input["serie"], "tipoComprobante" => $input["tipoComprobante"]));
                        return response()->json("La serie se actualizó correctamente", 200);
                    } else {
                        return response()->json("Hay una factura generada con la serie " . $serie2->serie . " y folio " . $serie2->folio, 500);
                    }
                }

            }else {
                $serie = Serie::where("serie", $input["serie"])->first();
                $serie2 = CfdiSerie::where("serie", $input["serie"])->orderby("id", "desc")->first();
                if (!$serie && !$serie2) {
                    Serie::create($input);
                    return response()->json("La serie se creó correctamente", 200);
                } else if ($serie && !$serie2) {
                    Serie::where("serie", $input["serie"])->update(array("folio" => $input["folio"], "tipoComprobante" => $input["tipoComprobante"]));
                    return response()->json("La serie se actualizó correctamente", 200);
                } else if (!$serie && $serie2) {
                    if ($input["folio"] > $serie2->folio) {
                        Serie::create($input);
                        return response()->json("La serie se creó correctamente", 200);
                    } else {
                        return response()->json("Hay una factura generada con la serie " . $serie2->serie . " y folio " . $serie2->folio, 500);
                    }
                } else if ($serie && $serie2) {
                    if ($input["folio"] > $serie2->folio) {
                        Serie::where("serie", $input["serie"])->update(array("folio" => $input["folio"], "tipoComprobante" => $input["tipoComprobante"]));
                        return response()->json("La serie se actualizó correctamente", 200);
                    } else {
                        return response()->json("Hay una factura generada con la serie " . $serie2->serie . " y folio " . $serie2->folio, 500);
                    }
                }
            }

        }catch (\Exception $e){
            return response()->json("[".$e->getLine()."] ".$e->getMessage(),500);
        }
    }
    function listSeries(){
        return view("empresa.dataSeries");
    }
    function borrarSerie(Request $request){
        try{
            $input = $request->all();
            $serie = Serie::find($input["id"]);
            $serie2 = CfdiSerie::where("serie",$serie->serie)->orderby("id","desc")->first();
            if($serie2){
                return response()->json("Hay facturas generadas con la serie ".$serie2->serie,500);
            }
            else{
                $serie->delete();
                return response()->json("Los datos se actualizaron correctamente",200);
            }
        }catch (\Exception $e){
            return response()->json("[".$e->getLine()."] ".$e->getMessage(),500);
        }
    }
    function deletePhotoPerfil(Request $request){
        $input = $request->all();
        $user = Auth::user();
        $path = public_path("/img/logos");
        $pathShow = $path.'\\'.$user->imagen;
        if(file_exists($pathShow) && is_file($pathShow)) {
            unlink($pathShow);
        }
        Empresa::update(array(
            "imagen"=>null
        ));
    }
    function uploadPhotoPerfil(Request $request){
        $input = $request->all();
        $licencia_id = Auth::user()->licencia_id;
        $path = public_path("/img/logos");
        GenericClass::checkandcreatePath($path);
        $nombre = '';
        if($request->hasFile('fotoperfil')){
            set_time_limit(0);
            $file = $request->file('fotoperfil');
            $nombre = $licencia_id."_".$file->getClientOriginalName();
            $upload = $path;
            $file->move($upload,$nombre);
        }
        return $nombre;
    }
    function guardarCSD(Request $request){
        $input = $request->all();
        $licencia_id = Auth::user()->licencia_id;
        $path = GenericClass::storage()."\\CSD";
        GenericClass::checkandcreatePath($path);
        if($request->hasFile('CSD_cer')){
            set_time_limit(0);
            $file = $request->file('CSD_cer');
            $nombreSerial = $licencia_id."_Serial.txt";
            $iniciaVigencia = $licencia_id."_IniciaVigencia.txt";
            $finVigencia = $licencia_id."_FinVigencia.txt";
            $tmpName = $_FILES["CSD_cer"]["tmp_name"];
            GenericClass::ejecutar('openssl.exe x509 -inform DER -in "'.$tmpName.'" -noout -serial > "'.$path.'\\'.$nombreSerial.'"');
            GenericClass::ejecutar('openssl.exe x509 -inform DER -in "'.$tmpName.'" -noout -startdate > "'.$path.'\\'.$iniciaVigencia.'"');
            GenericClass::ejecutar('openssl.exe x509 -inform DER -in "'.$tmpName.'" -noout -enddate > "'.$path.'\\'.$finVigencia.'"');
            $contents = file_get_contents($path.'\\'.$nombreSerial);
            $lines = explode(PHP_EOL, $contents);
            $linea = str_replace("serial=","",$lines[0]);
            $certificado = "";
            for($i=1;$i<strlen($linea);$i++){
                if (($i % 2) > 0) {
                    $certificado .= $linea[$i];
                }
            }
            $nombre = $certificado.".cer";
            $upload = $path;
            $file->move($upload,$nombre);

            $contents = file_get_contents($path.'\\'.$iniciaVigencia);
            $lines = explode(PHP_EOL, $contents);
            $iniciaVigencia = str_replace("notBefore=","",$lines[0]);
            $fechaIni = Carbon::createFromFormat("M d H:i:s Y T", trim($iniciaVigencia))->format('Y-m-d H:i:s');

            $contents = file_get_contents($path.'\\'.$finVigencia);
            $lines = explode(PHP_EOL, $contents);
            $iniciaVigencia = str_replace("notAfter=","",$lines[0]);
            $fechaFin = Carbon::createFromFormat("M d H:i:s Y T", trim($iniciaVigencia))->format('Y-m-d H:i:s');

            Certificado::updateOrCreate([
                "certificado"=>$certificado
            ],[
                "fechaIni"=>$fechaIni,
                "fechaFin"=>$fechaFin,
                "archivocer"=>$nombre
            ]);

            if(file_exists($path.'\\'.$nombreSerial)){
                unlink($path.'\\'.$nombreSerial);
            }
            if(file_exists($path.'\\'.$iniciaVigencia)){
                unlink($path.'\\'.$iniciaVigencia);
            }
            if(file_exists($path.'\\'.$finVigencia)){
                unlink($path.'\\'.$finVigencia);
            }

        }else{
            $certificado = $input["CSD_certificado"];
        }
        if($certificado!="") {
            if ($request->hasFile('CSD_key')) {
                set_time_limit(0);
                $file = $request->file('CSD_key');
                $nombre = $certificado.".key";
                $upload = $path;
                $file->move($upload, $nombre);
                Certificado::updateOrCreate([
                    "certificado" => $certificado
                ], [
                    "archivokey" => $nombre
                ]);
                if(file_exists($path.'\\'.$nombre)){
                    //12345678a
                    GenericClass::ejecutar('openssl.exe pkcs8 -inform DER -in "'.$path.'\\'.$nombre.'" -passin pass:'.$input["CSD_pass"].' -out "'.$path.'\\'.$nombre.'.pem"');
                }
            }
            if ($input["CSD_pass"] != "") {
                Certificado::updateOrCreate([
                    "certificado" => $certificado
                ], [
                    "archivopass" => base64_encode($input["CSD_pass"])
                ]);
            }
        }
    }
    function store(){

    }
}