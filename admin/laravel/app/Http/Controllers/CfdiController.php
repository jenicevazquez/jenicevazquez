<?php namespace App\Http\Controllers;


use App\Classes\FacturacionModerna;
use App\GenericClass;
use App\Libraries\Repositories\GeneralRepository;
use App\Models\CFDI\CfdiConcepto;
use App\Models\CFDI\CfdiEmisor;
use App\Models\CFDI\CfdiImpuesto;
use App\Models\CFDI\CfdiImpuestoConcepto;
use App\Models\CFDI\CfdiMetadata;
use App\Models\CFDI\CfdiReceptor;
use App\Models\CFDI\CfdiSerie;
use App\Models\CFDI\Cfdi;
use App\Models\CFDI\CfdiTimbreFiscal;
use App\Models\Cfdi\Producto;
use App\Models\CFDI\Serie;
use App\Models\CFDI\Cliente;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\File;

use Illuminate\Support\Facades\Session;
use Response;

class CfdiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        if(!Auth::guest())
            GenericClass::setConnectionByLicencia(Session::get("workspace"));
    }
    public function index(){

        return view("cfdi.index");
    }
    public function create(){
        return view("cfdi.create");
    }
    public function show($id){

    }
    function partialReload(Request $request){
        $input = $request->all();
        $vista = $input["src"];
        $q = $input["valores"];
        return view($vista)->with("q",$q)->render();
    }
    function getFolio(Request $request){
        $input = $request->all();
        $serie = CfdiSerie::where("serie",$input["serie"])->select(DB::raw("MAX(folio) as folio"))->groupby("serie")->first();
        if($serie){
            return $serie->folio++;
        }else{
            $serie = Serie::where("serie",$input["serie"])->first();
            return $serie->folio;
        }
    }
    function organizarDatosCapturaCfdi($input){
        try {
            $receptor = $input["receptor"];

            $partes = explode(" - ", $receptor["Receptor_RfcCargado"]);

            $input["cliente"] = Cliente::where("Rfc", $partes[0])->first();
            //dd($input["cliente"]);
            $traslados = [];
            $retenciones = [];
            if (isset($input["conceptos"])) {
                foreach ($input["conceptos"] as $i => $concepto) {
                    $descripcion = $concepto["producto"];
                    $partes = explode(" - ", $descripcion);
                    $input["conceptos"][$i]["producto"] = $partes[0];
                    $trasladosConcepto = $concepto["traslados"] ?? array();
                    $retencionesConcepto = $concepto["retenciones"] ?? array();
                    foreach ($trasladosConcepto as $t) {
                        if ($t["tipo"] == "Tasa") {
                            $k = $t["impuesto"] . "_" . $t["tipo"] . "_" . $t["tasa"];
                        } else {
                            $k = $t["impuesto"] . "_" . $t["tipo"] . "_" . $t["cuota"];
                        }

                        if (isset($traslados[$k])) {
                            $traslados[$k] += $t["importe"];
                        } else {
                            $traslados[$k] = $t["importe"];
                        }
                    }

                    foreach ($retencionesConcepto as $t) {
                        if ($t["tipo"] == "Tasa") {
                            $k = $t["impuesto"] . "_" . $t["tipo"] . "_" . $t["tasa"];
                        } else {
                            $k = $t["impuesto"] . "_" . $t["tipo"] . "_" . $t["cuota"];
                        }
                        if (isset($retenciones[$k])) {
                            $retenciones[$k] += $t["importe"];
                        } else {
                            $retenciones[$k] = $t["importe"];
                        }
                    }
                }
            }
            $input["traslados"] = $traslados;
            $input["retenciones"] = $retenciones;
            return $input;
        }
        catch (\Exception $e){
            return ["error","[".$e->getLine()." ".basename($e->getFile())."] ".$e->getMessage()];
        }
    }
    function vistaPrevia(Request $request){
        $input = $request->all();
        $input = $this->organizarDatosCapturaCfdi($input);

        $vista = view("templates.cfdi40")->with("input",$input);
        return $vista;
    }
    function vistaPreviaPdf(Request $request){
        try {
            $input = $request->all();
            $input = $this->organizarDatosCapturaCfdi($input);
            $user = Auth::user()->id;
            $name = bin2hex($user . "-0");
            $pathShow = "C:\\RYVConsultores\\" . Auth::user()->licencia_id . "\\temp\\" . $name . ".pdf";
            if (file_exists($pathShow)) {
                unlink($pathShow);
            }
            //GENERAMOS VISTA DEL PDF
            $vista = view("templates.cfdi40Pdf")->with("input", $input);

            $res = GenericClass::generarPDF($pathShow, $vista, null, null, 0);

            if($res[0]=="success"){
                return $name;
            }
            else{
                return response()->json($res[1],500);
            }

        }
        catch (\Exception $e){
            return response()->json("[".$e->getLine()." ".basename($e->getFile())."] ".$e->getMessage(),500);
        }
    }
    function verPdf($name){
        $name2 = hex2bin($name);
        $partes = explode("-",$name2);
        $id = $partes[1];
        $pathShow = "C:\\RYVConsultores\\".Auth::user()->licencia_id."\\temp\\".$name.".pdf";
        if (!file_exists($pathShow)) {
            $pathShow = storage_path("dummy.pdf");
        }
        $mime = mime_content_type($pathShow);
        return Response::make(file_get_contents($pathShow), 200, [
            'Content-Type' => $mime,
            'Content-Disposition' => 'inline; ' . $pathShow,
        ]);
    }
    function verCfdi($uuid){
        $pathShow = "C:\\RYVConsultores\\".Auth::user()->licencia_id."\\Facturas\\".$uuid."\\".$uuid.".pdf";
        if (file_exists($pathShow)) {
            $mime = mime_content_type($pathShow);

            return Response::make(file_get_contents($pathShow), 200, [
                'Content-Type' => $mime,
                'Content-Disposition' => 'inline; ' . $pathShow,
            ]);
        }
        else{
            dd("No se encontro ".$pathShow);
        }
    }
    function guardarComprobante(Request $request){
        try {
            $input = $request->all();
            $input = $this->organizarDatosCapturaCfdi($input);
            $res = $this->guardarDatosCfdi($input);
            if($res[0]=="success") {
                return response()->json("El comprobante se a guardado con exito", 200);
            }
            else{
                return response()->json($res[1],500);
            }
        }
        catch (\Exception $e){
            return response()->json("[".$e->getLine()." ".basename($e->getFile())."] ".$e->getMessage(),500);
        }
    }
    function timbrarComprobante(Request $request){
        try {
            $input = $request->all();
            $input = $this->organizarDatosCapturaCfdi($input);
            $res = $this->guardarDatosCfdi($input);
            if($res[0]=="success") {
                $id = $res[1];
                $cfdiData = Cfdi::find($id);
                if($cfdiData) {
                    $debug = 1;
                    $licencia = GenericClass::user()->licencia_id;
                    $path = "C:\\RYVConsultores\\".$licencia."\\CSD";
                    $rfc_emisor =  GenericClass::empresa()->Rfc;
                    $numero_certificado =  GenericClass::certificado()->certificado;
                    $archivo_cer =  $path."\\".GenericClass::certificado()->archivocer;
                    $archivo_pem =  $path."\\".GenericClass::certificado()->archivokey.".pem";
                    $url_timbrado = "https://t1demo.facturacionmoderna.com/timbrado/wsdl";
                    $user_id = "UsuarioPruebasWS";
                    $user_password = "b9ec2afa3361a59af4b4d102d3f704eabdf097d4";
                    $cfdi = $cfdiData->generarXML();
                    file_put_contents($path."\\sinsellar.xml",$cfdi);
                    $cfdi = $this->sellarXML($cfdi, $numero_certificado, $archivo_cer, $archivo_pem);
                    if($cfdi[0]=="success") {
                        $cfdi = $cfdi[1];
                        file_put_contents($path."\\SELLADO.xml",$cfdi);
                        $parametros = array('emisorRFC' => $rfc_emisor, 'UserID' => $user_id, 'UserPass' => $user_password);
                        $cliente = new FacturacionModerna($url_timbrado, $parametros, $debug);
                        if ($cliente->timbrar($cfdi)) {
                            if ($cliente->xml) {
                                $contents = $cliente->xml;
                                $uuid = $cliente->UUID;
                                $path = GenericClass::storage() . "\\Facturas\\" . $uuid;
                                GenericClass::checkandcreatePath($path);
                                file_put_contents($path."\\".$uuid . ".xml", $contents);
                                $namespaces = GenericClass::getPrefixNamespaces($contents);
                                $result = str_replace($namespaces, '', $contents);
                                $xml = simplexml_load_string($result);
                                $comprobante = $xml->attributes();
                                if (isset($xml->Complemento->TimbreFiscalDigital)) {
                                    Cfdi::where("id",$cfdiData->id)->update(array(
                                      "uuid" => $uuid
                                    , "Sello" => (string)$comprobante["Sello"]
                                    , "NoCertificado" => (string)$comprobante["NoCertificado"]
                                    , "Certificado" => (string)$comprobante["Certificado"]
                                    ));
                                    CfdiMetadata::updateOrCreate([
                                        "Uuid" => $uuid
                                    ], [
                                        "RfcEmisor" => $cfdiData->emisorRow->Rfc
                                        , "NombreEmisor" => $cfdiData->emisorRow->Nombre
                                        , "RfcReceptor" => $cfdiData->receptorRow->Rfc
                                        , "NombreReceptor" => $cfdiData->receptorRow->Nombre
                                        , "FechaEmision" => $cfdiData->Fecha
                                        , "Monto" => $cfdiData->Total
                                        , "EfectoComprobante" => $cfdiData->TipoDeComprobante
                                        , "cfdi_id" => $cfdiData->id
                                    ]);
                                    $timbre = $xml->Complemento->TimbreFiscalDigital->attributes();
                                    $uuid = (string)$timbre["UUID"];
                                    $timbre["FechaTimbrado"] = str_replace("T", " ", (string)$timbre["FechaTimbrado"]);
                                    $timbre["FechaTimbrado"] = str_replace("Z", "", (string)$timbre["FechaTimbrado"]);
                                    CfdiTimbreFiscal::updateOrcreate([
                                        "cfdi_id" =>  $cfdiData->id
                                    ], [
                                        "Version" => (string)$timbre["Version"]
                                        , "UUID" => (string)$timbre["UUID"]
                                        , "FechaTimbrado" => (string)$timbre["FechaTimbrado"]
                                        , "RfcProvCertif" => (string)$timbre["RfcProvCertif"]
                                        , "Leyenda" => isset($timbre["Leyenda"]) ? (string)$timbre["Leyenda"] : null
                                        , "SelloCFDI" => (string)$timbre["SelloCFD"]
                                        , "NoCertificadoSAT" => (string)$timbre["NoCertificadoSAT"]
                                        , "SelloSAT" => (string)$timbre["SelloSAT"]
                                    ]);
                                    $input["timbre"] = $timbre;
                                    /**/
                                    $input["comprobante"]["NoCertificado"] = (string)$comprobante["NoCertificado"];
                                    $input["comprobante"]["Sello"] = (string)$comprobante["Sello"];
                                    $input["comprobante"]["Certificado"] = (string)$comprobante["Certificado"];
                                    $pathShow = $path."\\".$uuid . ".pdf";
                                    $vista = view("templates.cfdi40Pdf")->with("input",$input);
                                    GenericClass::generarPDF($pathShow, $vista, null, null, 0);
                                    return response()->json($uuid,200);

                                }
                            }

                        } else {
                            return response()->json("[" . $cliente->ultimoCodigoError . "] - " . $cliente->ultimoError . "\n",500);
                        }
                    }else{
                        return response()->json($cfdi[1],500);
                    }
                }
            }
            else{
                return response()->json($res[1],500);
            }
        }
        catch (\Exception $e){
            return response()->json("[".$e->getLine()." ".basename($e->getFile())."] ".$e->getMessage(),500);
        }
    }
    function datapanel(Request $request){
        $input = $request->all();
        $facturas = Cfdi::paginate(25);
        return view("cfdi.datapanel")->with("facturas",$facturas);
    }
    function guardarDatosCfdi($input){
        try {

            $emisor = CfdiEmisor::firstOrCreate(array(
                "Rfc" => $input["emisor"]["Emisor_Rfc"]
            , "Nombre" => $input["emisor"]["Emisor_Nombre"]
            , "RegimenFiscal" => $input["emisor"]["Emisor_RegimenFiscal"]
            ));
            $cliente = $input["cliente"];
            $receptor = CfdiReceptor::firstOrCreate(array(
                "Rfc" => $cliente->Rfc
            , "Nombre" => $cliente->Nombre
            , "ResidenciaFiscal" => $cliente->ResidenciaFiscal
            , "NumRegIdTrib" => $cliente->NumRegIdTrib
            , "RegimenFiscal" => $cliente->RegimenFiscal
            , "DomicilioFiscal"=> $cliente->DomicilioFiscal
            , "UsoCFDI" => $input["receptor"]["Receptor_UsoCFDI"]
            ));
            $fecha = str_replace('T',' ',$input["comprobante"]["Comprobante_Fecha"]);
            $fecha = Carbon::createFromFormat('Y-m-d H:i:s', $fecha);

            $cfdi = Cfdi::firstOrCreate(array(
                "Version" => $input["comprobante"]["Comprobante_Version"]
            , "Serie" => $input["comprobante"]["Comprobante_Serie"]
            , "Folio" => $input["comprobante"]["Comprobante_Folio"]
            , "Fecha" => $fecha
            , "FormaPago" => $input["comprobante"]["Comprobante_FormaPago"]
            , "CondicionesDePago" => $input["comprobante"]["Comprobante_CondicionesDePago"]
            , "SubTotal" => $input["comprobante"]["Comprobante_SubTotal"]
            , "Descuento" => $input["comprobante"]["Comprobante_Descuento"]==""? 0.00:$input["comprobante"]["Comprobante_Descuento"]
            , "Moneda" => $input["comprobante"]["Comprobante_Moneda"]
            , "TipoCambio" => $input["comprobante"]["Comprobante_TipoCambio"]==""? 0.00:$input["comprobante"]["Comprobante_TipoCambio"]
            , "Total" => $input["comprobante"]["Comprobante_Total"]
            , "TipoDeComprobante" => $input["comprobante"]["Comprobante_TipoComprobante"]
            , "MetodoPago" => $input["comprobante"]["Comprobante_MetodoPago"]
            , "LugarExpedicion" => $input["comprobante"]["Comprobante_LugarExpedicion"]
            , "Exportacion" => $input["comprobante"]["Comprobante_Exportacion"]
            , "emisor" => $emisor->id
            , "receptor" => $receptor->id
            ));
            $folio = $input["comprobante"]["Comprobante_Folio"];
            $parts = explode("-",$folio);
            $parts[count($parts)-1] = $parts[count($parts)-1]+1;
            $folio = implode("-",$parts);
            Serie::where("Serie",$input["comprobante"]["Comprobante_Serie"])->update(array(
                "Folio"=>$folio
            ));
            CfdiImpuestoConcepto::where("cfdi_id",$cfdi->id)->delete();
            CfdiConcepto::where("cfdi_id",$cfdi->id)->delete();
            foreach ($input["conceptos"] as $i => $concepto) {
                //dd($concepto);
                if($concepto["cantidad"]>0) {
                    $partes = explode(" - ", $concepto["claveunidad"]);
                    $concepto["claveunidad"] = $partes[0];
                    $cfdiconcepto = CfdiConcepto::firstOrCreate(array(
                        'cfdi_id' => $cfdi->id
                    , 'ClaveProvServ' => $concepto["producto"]
                    , 'NoIdentificacion' => $concepto["noIdentificacion"]
                    , 'Cantidad' => $concepto["cantidad"]
                    , 'ClaveUnidad' => $concepto["claveunidad"]
                    , 'Unidad' => $concepto["unidad"]
                    , 'Descripcion' => $concepto["descripcion"]
                    , 'ValorUnitario' => $concepto["unitario"]
                    , 'Importe' => $concepto["importe"]
                    , 'Descuento' => $concepto["descuento"] == "" ? 0.00 : $concepto["descuento"]
                    , 'ObjetoImp' => $concepto["objetoImpuesto"]
                    , 'secuencia' => $i + 1
                    ));

                    if(isset($concepto["traslados"])) {
                        foreach ($concepto["traslados"] as $j => $impuesto) {
                            if ($impuesto["tipo"] == "Tasa") {
                                $tasaocuota = $impuesto["tasa"];
                                $importe = $concepto["base"] * ($impuesto["tasa"] / 100);
                            } else {
                                $tasaocuota = $impuesto["cuota"];
                                $importe = $tasaocuota;
                            }
                            CfdiImpuestoConcepto::firstOrCreate(array(
                                'cfdi_id' => $cfdi->id
                            , 'concepto_id' => $cfdiconcepto->id
                            , 'Base' => $concepto["base"]
                            , 'Impuesto' => $impuesto["impuesto"]
                            , 'TipoFactor' => $impuesto["tipo"]
                            , 'TasaOCuota' => $tasaocuota
                            , 'Importe' => $importe
                            , 'tipo' => 1
                            , 'secuencia' => $j + 1
                            ));
                        }
                    }
                    if(isset($concepto["retenciones"])) {
                        foreach ($concepto["retenciones"] as $j => $impuesto) {
                            if ($impuesto["tipo"] == "Tasa") {
                                $tasaocuota = $impuesto["tasa"];
                                $importe = $concepto["base"] * ($impuesto["tasa"] / 100);
                            } else {
                                $tasaocuota = $impuesto["cuota"];
                                $importe = $tasaocuota;
                            }
                            CfdiImpuestoConcepto::firstOrCreate(array(
                                'cfdi_id' => $cfdi->id
                            , 'concepto_id' => $cfdiconcepto->id
                            , 'Base' => $concepto["base"]
                            , 'Impuesto' => $impuesto["impuesto"]
                            , 'TipoFactor' => $impuesto["tipo"]
                            , 'TasaOCuota' => $tasaocuota
                            , 'Importe' => $importe
                            , 'tipo' => 2
                            , 'secuencia' => $j + 1
                            ));
                        }
                    }
                }
            }
            return ["success",$cfdi->id];
        }
        catch (\Exception $e){
            return ["error", "[".$e->getLine()." ".basename($e->getFile())."] ".$e->getMessage()];
        }
    }
    function obtenerDatosCfdi($id){
        try {
            $cfdi = Cfdi::find($id);
            $emisor = $cfdi->emisorRow;
            $input["emisor"]["Emisor_Rfc"] = $emisor->Rfc;
            $input["emisor"]["Emisor_Nombre"] = $emisor->Nombre;
            $input["emisor"]["Emisor_RegimenFiscal"] = $emisor->RegimenFiscal;
            $receptor = $cfdi->receptorRow;
            $cliente = Cliente::where("Rfc",$receptor->Rfc);
            $input["cliente"] = $cliente;
            $input["receptor"]["Receptor_UsoCFDI"] = $receptor->UsoCFDI;
            $input["receptor"]["Receptor_RfcCargado"] = $receptor->Rfc;
            $input["comprobante"]["Comprobante_Fecha"] = str_replace(' ','T',$cfdi->Fecha);
            $input["comprobante"]["Comprobante_Version"] = $cfdi->Version;
            $input["comprobante"]["Comprobante_Serie"] = $cfdi->Serie;
            $input["comprobante"]["Comprobante_Folio"] = $cfdi->Folio;
            $input["comprobante"]["Comprobante_FormaPago"] = $cfdi->FormaPago;
            $input["comprobante"]["Comprobante_CondicionesDePago"] = $cfdi->CondicionesDePago;
            $input["comprobante"]["Comprobante_SubTotal"] = $cfdi->SubTotal;
            $input["comprobante"]["Comprobante_Descuento"] = $cfdi->Descuento;
            $input["comprobante"]["Comprobante_Moneda"] = $cfdi->Moneda;
            $input["comprobante"]["Comprobante_TipoCambio"] = $cfdi->TipoCambio;
            $input["comprobante"]["Comprobante_Total"] = $cfdi->Total;
            $input["comprobante"]["Comprobante_TipoComprobante"] = $cfdi->TipoDeComprobante;
            $input["comprobante"]["Comprobante_MetodoPago"] = $cfdi->MetodoPago;
            $input["comprobante"]["Comprobante_LugarExpedicion"] = $cfdi->LugarExpedicion;
            $input["comprobante"]["Comprobante_Exportacion"] = $cfdi->Exportacion;
            $input["conceptos"] = [];
            foreach($cfdi->cfdiConceptos as $conceptoRow){
                $concepto["cantidad"] = $conceptoRow->Cantidad;
                $concepto["claveunidad"] = $conceptoRow->ClaveUnidad;
                $concepto["producto"] = $conceptoRow->ClaveProvServ;
                $concepto["noIdentificacion"] = $conceptoRow->NoIdentificacion;
                $concepto["claveunidad"] = $conceptoRow->ClaveUnidad;
                $concepto["unidad"] = $conceptoRow->Unidad;
                $concepto["descripcion"] = $conceptoRow->Descripcion;
                $concepto["unitario"] = $conceptoRow->ValorUnitario;
                $concepto["importe"] = $conceptoRow->Importe;
                $concepto["descuento"] = $conceptoRow->Descuento;
                $concepto["objetoImpuesto"] = $conceptoRow->ObjetoImp;
                foreach ($conceptoRow->trasladosData as $impuestoRow){
                    $impuesto["tipo"] = $impuestoRow->TipoFactor;
                    $impuesto["tasa"] = $impuestoRow->TasaOCuota;
                    $impuesto["cuota"] = $impuestoRow->TasaOCuota;
                    $concepto["base"] = $impuestoRow->Base;
                    $impuesto["impuesto"] = $impuestoRow->Impuesto;
                    $impuesto["importe"] = $impuestoRow->Importe;
                    $concepto["traslados"][] = $impuesto;
                }
                foreach ($conceptoRow->retencionesData as $impuestoRow){
                    $impuesto["tipo"] = $impuestoRow->TipoFactor;
                    $impuesto["tasa"] = $impuestoRow->TasaOCuota;
                    $impuesto["cuota"] = $impuestoRow->TasaOCuota;
                    $concepto["base"] = $impuestoRow->Base;
                    $impuesto["impuesto"] = $impuestoRow->Impuesto;
                    $impuesto["importe"] = $impuestoRow->Importe;
                    $concepto["retenciones"][] = $impuesto;
                }
                $input["conceptos"][] = $concepto;
            }
            if($cfdi->cfdiMetadata){
                $input["comprobante"]["NoCertificado"]= $cfdi->NoCertificado;
                $input["comprobante"]["Sello"] = $cfdi->Sello;
                $input["comprobante"]["Certificado"] = $cfdi->Certificado;

                $timbreRow = $cfdi->cfdiTimbre;
                $timbre["FechaTimbrado"] = $timbreRow->FechaTimbrado;
                $timbre["UUID"] = $timbreRow->UUID;
                $timbre["NoCertificadoSAT"] = $timbreRow->NoCertificadoSAT;
                $timbre["SelloCFD"] = $timbreRow->SelloCFD;
                $timbre["Version"] = $timbreRow->Version;
                $timbre["RfcProvCertif"] = $timbreRow->RfcProvCertif;
                $timbre["SelloSAT"] = $timbreRow->SelloSAT;
                $input["timbre"] = $timbre;
            }
            return $input;
        }
        catch (\Exception $e){
            return "[".$e->getLine()." ".basename($e->getFile())."] ".$e->getMessage();
        }
    }
    function sellarXML($cfdi, $numero_certificado, $archivo_cer, $archivo_pem){
        try {
            $private = openssl_pkey_get_private(file_get_contents($archivo_pem));
            $certificado = str_replace(array('\n', '\r'), '', base64_encode(file_get_contents($archivo_cer)));

            $xdoc = new \DomDocument();
            $xdoc->loadXML($cfdi) or die("XML invalido");

            $c = $xdoc->getElementsByTagNameNS('http://www.sat.gob.mx/cfd/4', 'Comprobante')->item(0);
            $c->setAttribute('Certificado', $certificado);
            $c->setAttribute('NoCertificado', $numero_certificado);

            $XSL = new \DOMDocument();
            $XSL->load(app_path('/Xslt/cadenaoriginal.xslt')) or die("XSLT invalido");

            $proc = new \XSLTProcessor;
            $proc->importStyleSheet($XSL);

            $cadena_original = $proc->transformToXML($xdoc);
            openssl_sign($cadena_original, $sig, $private, OPENSSL_ALGO_SHA256);
            $sello = base64_encode($sig);


            $c->setAttribute('Sello', $sello);

            return ["success",$xdoc->saveXML()];
        }
        catch (\Exception $e){
            return ["error", "[".$e->getLine()." ".basename($e->getFile())."] ".$e->getMessage()];
        }
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
            $conceptos = [];
            foreach ($lines as $line){
                $fields = explode("|",$line);
                if($fields[0]=="551"){
                    $producto = Producto::where([
                        "Fraccion"=>$fields[2]
                        ,"SubdivisionFraccion"=>$fields[4]
                        ,"DescripcionMercancia"=>$fields[5]
                        ,"PrecioUnitario"=>$fields[6]
                        ,"UnidadMedidaComercial"=>$fields[11]
                    ])->first();
                    if($producto) {
                        $cantidad = $fields[10];
                        $concepto = array(
                            "producto" => $producto->ClaveProducto,
                            "claveunidad" => $producto->ClaveUnidad,
                            "cantidad" => $cantidad,
                            "noIdentificacion" => $producto->CodigoMercanciaProducto,
                            "unidad" => $producto->Unidad,
                            "descripcion" => $producto->DescripcionMercancia,
                            "unitario" => $producto->PrecioUnitario,
                            "importe" => $producto->PrecioUnitario * $cantidad,
                            "descuento" => 0,
                            "objetoImpuesto" => "01",
                            "impuestos" => 0,
                            "base" => 0,
                            "subtotal" => $producto->PrecioUnitario * $cantidad,
                            "traslados" => [],
                            "retenciones" => []
                        );
                        $conceptos[] = $concepto;
                    }
                }
            }
            return $conceptos;
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
            $conceptos = [];
            foreach ($lines as $line){
                $fields = explode("|",$line);
                if($fields[0]=="551"){
                    $producto = Producto::where([
                        "Fraccion"=>$fields[1]
                        ,"DescripcionMercancia"=>$fields[2]
                        ,"PrecioUnitario"=>round($fields[4]/$fields[5],2)
                        ,"UnidadMedidaComercial"=>$fields[6]
                    ])->first();
                    if($producto) {
                        $cantidad = $fields[5];
                        $concepto = array(
                            "producto" => $producto->ClaveProducto,
                            "claveunidad" => $producto->ClaveUnidad,
                            "cantidad" => $cantidad,
                            "noIdentificacion" => $producto->CodigoMercanciaProducto,
                            "unidad" => $producto->Unidad,
                            "descripcion" => $producto->DescripcionMercancia,
                            "unitario" => $producto->PrecioUnitario,
                            "importe" => $producto->PrecioUnitario * $cantidad,
                            "descuento" => 0,
                            "objetoImpuesto" => "01",
                            "impuestos" => 0,
                            "base" => 0,
                            "subtotal" => $producto->PrecioUnitario * $cantidad,
                            "traslados" => [],
                            "retenciones" => []
                        );
                        $conceptos[] = $concepto;
                    }
                }
            }
            return $conceptos;
        }
    }
    function descargarCfdi(Request $request){
        $input = $request->all();
        $uuid = $input["uuid"];
        $path = GenericClass::storage() . "\\Facturas\\" . $uuid;
        $filenames[] = $path."\\".$uuid . ".xml";
        $filenames[] = $path."\\".$uuid . ".pdf";
        $filenamesDst[] = $uuid . ".xml";
        $filenamesDst[] = $uuid . ".pdf";
        $namezip = $uuid.".zip";
        $zip = GenericClass::makeZip($filenames,$filenamesDst,$path,$namezip);
        return $zip;
    }
    function zip($filename){
        $filename = base64_decode($filename);
        return Response::make(file_get_contents($filename),200,[

            'Content-Type' => 'application/zip',
            'Content-Disposition' => 'inline; '.$filename,

        ]);
    }
    function proforma($id){
        $input = $this->obtenerDatosCfdi($id);
        $input = $this->organizarDatosCapturaCfdi($input);
        //dd($input);
        $vista = view("templates.cfdi40Pdf")->with("input",$input);
        return $vista;
    }
    function proforma2($id){
        $input = $this->obtenerDatosCfdi($id);
        $input = $this->organizarDatosCapturaCfdi($input);
        //dd($input);
        $vista = view("templates.cfdi40Pdf")->with("input",$input);
        $user = Auth::user()->id;
        $name = bin2hex($user . "-0");
        $pathShow = "C:\\RYVConsultores\\" . Auth::user()->licencia_id . "\\temp\\" . $name . ".pdf";
        if (file_exists($pathShow)) {
            unlink($pathShow);
        }
        //GENERAMOS VISTA DEL PDF
        $vista = view("templates.cfdi40Pdf")->with("input", $input);

        $res = GenericClass::generarPDF($pathShow, $vista, null, null, 0);

        if($res[0]=="success"){
            $mime = mime_content_type($pathShow);
            return Response::make(file_get_contents($pathShow), 200, [
                'Content-Type' => $mime,
                'Content-Disposition' => 'inline; ' . $pathShow,
            ]);
        }
        else{
            return response()->json($res[1],500);
        }

    }
}