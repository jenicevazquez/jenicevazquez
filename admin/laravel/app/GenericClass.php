<?php namespace App;

use App\Http\Controllers\Exception;
use App\Models\CFDI\CfdiSerie;
use App\Models\CFDI\Empresa;
use App\Models\CFDI\Serie;
use App\Models\cfdi40\CCodigoPostal;
use App\Models\cfdi40\CExportacion;
use App\Models\cfdi40\CPais;
use App\Models\CFDI\Cliente;
use App\Models\CFDI\Certificado;
use App\Models\Conexion;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

use Illuminate\Container\Container;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Collection;

use App\Models\CFDI\CfdiEmisor;
use App\Models\CFDI\CfdiReceptor;
use App\Models\Cfdi40\CTipoDeComprobante;
use App\Models\Cfdi40\CRegimenFiscal;
use App\Models\Cfdi40\CUsoCFDI;
use App\Models\Cfdi40\CMoneda;
use App\Models\Cfdi40\CFormaPago;
use App\Models\Cfdi40\CMetodoPago;
use App\Models\Cfdi40\CTipoRelacion;
use App\Models\Cfdi40\CClaveProdServ;
use App\Models\Cfdi40\CImpuesto;
use App\Models\Cfdi40\CObjetoImp;
use Illuminate\Support\Facades\Session;
use ZipArchive;

use Knp\Snappy\Pdf;

trait GenericClass
{
    public static function get_page_mod_time()
    {
        $incls = get_included_files();
        $incls = array_filter($incls, "is_file");
        $mod_times = array_map('filemtime', $incls);
        return max($mod_times);
    }
    public static function user()
    {
        $user = Session::get("user_id");
        return \App\User::where('users.id', $user)
            ->select("users.*")->first();
    }
    public static function getFilem($url){
        clearstatcache();
        if(file_exists($_SERVER["DOCUMENT_ROOT"].$url))
            return filemtime($_SERVER["DOCUMENT_ROOT"].$url);
        else
            return 1;
    }
    public static function obtenerArchivos($path){
        $archivos = scandir($path);
        $removeDirs = array(".", "..");
        return array_diff($archivos, $removeDirs);
    }
    public static function checkandcreatePath($path){
        $path = str_replace("/","\\",$path);
        $partes = explode("\\", $path);
        $cadena = $partes[0];
        foreach($partes as $i=>$parte){
            if($i>0)
                $cadena .= '\\'. $parte;
            if(!is_dir($cadena)){
                mkdir($cadena);
            }
        }
    }
    public static function tipoDeCambio(){
        return file_get_contents('https://dev.ryvconsultores.com.mx/tipoCambio/'.bin2hex(date('Y-m-d')));
    }
    public static function selectEmisores(){
        return CfdiEmisor::lists('Rfc','id');
    }
    public static function selectReceptores(){
        return  CfdiReceptor::select(DB::raw("Rfc + ' - ' + Nombre as Rfc"),'id')->lists('Rfc','id');
    }
    public static function selectClientes(){
        return  Cliente::select(DB::raw("Rfc + ' - ' + Nombre as Rfc"),'id')->orderby('Rfc')->lists('Rfc','id');
    }
    public static function selectSeries(){
        return  Serie::select("serie","serie as clave")->orderby('serie')->lists('serie','clave');
    }
    public static function getSeries(){
        return  Serie::orderby('serie')->get();
    }
    public static function selectTiposComprobantes(){
        return CTipoDeComprobante::select(DB::raw("c_tipodecomprobante + ' - ' + descripcion as name"),'c_tipodecomprobante as clave')->lists('name','clave');
    }
    public static function selectRegimenesFiscales(){
        return CRegimenFiscal::select(DB::raw("c_regimenfiscal + ' - ' + descripcion as name"),'c_regimenfiscal as clave')->lists('name','clave');
    }
    public static function selectUsoCFDIFisica(){
        return CUsoCFDI::select(DB::raw("c_usocfdi + ' - ' + descripcion as name"),'c_usocfdi as clave')->where("aplica_para_tipo_persona","Sí")->lists('name','clave');
    }
    public static function selectUsoCFDI(){
        return CUsoCFDI::select(DB::raw("c_usocfdi + ' - ' + descripcion as name"),'c_usocfdi as clave')->lists('name','clave');
    }
    public static function selectUsoCFDIMoral(){
        return CUsoCFDI::select(DB::raw("c_usocfdi + ' - ' + descripcion as name"),'c_usocfdi as clave')->where("aplica_para_tipo_persona","Sí")->lists('name','clave');
    }
    public static function getUsoCFDI($clave){
        return CUsoCFDI::where("c_usocfdi",$clave)->first();
    }
    public static function selectMonedas(){
        return CMoneda::select(DB::raw("c_moneda + ' - ' + descripcion as name"),'c_moneda as clave')->lists('name','clave');
    }
    public static function selectFormasPago(){
        return CFormaPago::select(DB::raw("c_formapago + ' - ' + descripcion as name"),'c_formapago as clave')->lists('name','clave');
    }
    public static function selectMetodosPago(){
        return CMetodoPago::select(DB::raw("c_metodopago + ' - ' + descripcion as name"),'c_metodopago as clave')->lists('name','clave');
    }
    public static function selectExportacion(){
        return CExportacion::select(DB::raw("c_exportacion + ' - ' + descripcion as name"),'c_exportacion as clave')->lists('name','clave');
    }
    public static function selectTiposRelacion(){
        return CTipoRelacion::select(DB::raw("c_tiporelacion + ' - ' + descripcion as name"),'c_tiporelacion as clave')->lists('name','clave');
    }
    public static function selectProductoServicio($q){
        return CClaveProdServ::select(DB::raw("c_claveprodserv + ' - ' + descripcion as name"),'c_claveprodserv as clave')
            ->whereRaw("(c_claveprodserv like '%".$q."%' OR descripcion like '%".$q."%')")->take(1000)->lists('name','clave');
    }
    public static function selectCodigoPostal($q){
        return CCodigoPostal::select(DB::raw("c_codigopostal AS name"),'c_codigopostal as clave')
            ->whereRaw("(c_codigopostal like '%".$q."%')")->take(1000)->lists('name','clave');
    }
    public static function selectPais(){
        return CPais::select(DB::raw("c_pais + ' - ' + descripcion as name"),'c_pais as clave')->lists('name','clave');
    }
    public static function selectObjetoImp(){

        return CObjetoImp::select(DB::raw("c_objetoimp + ' - ' + descripcion as name"),'c_objetoimp as clave')->lists('name','clave');
    }
    public static function getImpuesto($clave){
        return CImpuesto::where("c_impuesto",$clave)->first();
    }
    public static function getImpuestoRetencion(){
        return CImpuesto::where("retencion","Si")->get();
    }
    public static function getImpuestoTraslado(){
        return CImpuesto::where("traslado","Si")->get();
    }

    public static function empresa(){
        $empresa = Empresa::first();
        if(!$empresa)
            return new Empresa();
        return $empresa;
    }
    public static function setConnectionByLicencia($licencia){

        $conexion = DB::connection("admin")->table("conexiones")->where("clave",$licencia)->where("sistema",7)->first();

        if($conexion) {

            DB::purge('facturacion_cliente');

            \Config::set("database.connections.facturacion_cliente", [
                'driver' => $conexion->tipo,
                'host' => $conexion->servidor,
                'username' => $conexion->usuario,
                'database' => $conexion->basededatos,
                'password' => base64_decode($conexion->contrasenia)
            ]);

            return true;
        }
        else
            return false;


    }
    public static function setDinamico($conexion){
        DB::purge('dinamico');
        \Config::set("database.connections.dinamico", [
            'driver' => $conexion->tipo,
            'host' => $conexion->servidor,
            'username' => $conexion->usuario,
            'database' => $conexion->basededatos,
            'password' => base64_decode($conexion->contrasenia)
        ]);
    }
    public static function getClientebyRFC($rfc){
        return Cliente::where("rfc",$rfc)->first();
    }
    public static function regimenesC($clave){
        $data = DB::connection("ryv_a20")->table("regimenesFiscales")->where("clave",$clave)->first();
        return $data? $data->descripcion:null;
    }
    public static function usosCfdiC($clave){
        $data = DB::connection("ryv_a20")->table("usosCfdi")->where("clave",$clave)->first();
        return $data? $data->descripcion:null;
    }
    public static function formasPago($clave){
        $data = DB::connection("ryv_a20")->table("formasPago")->where("clave",$clave)->first();
        return $data? $data->descripcion:null;
    }
    public static function tipoComprobante($clave){
        $data = DB::connection("ryv_a20")->table("tiposComprobantes")->where("clave",$clave)->first();
        return $data? $data->descripcion:null;
    }
    public static function convertir($numero){
        $partes = explode('.',$numero);
        $partes[1] = isset($partes[1])? $partes[1]:'00';
        $numf = GenericClass::milmillon($partes[0]);
        return $numf.' PESOS '.$partes[1].'/100 M.N.';
    }
    public static function unidad($numuero){
        //dd($numuero);
        switch ($numuero)
        {
            case 9:
            {
                $numu = "NUEVE";
                break;
            }
            case 8:
            {
                $numu = "OCHO";
                break;
            }
            case 7:
            {
                $numu = "SIETE";
                break;
            }
            case 6:
            {
                $numu = "SEIS";
                break;
            }
            case 5:
            {
                $numu = "CINCO";
                break;
            }
            case 4:
            {
                $numu = "CUATRO";
                break;
            }
            case 3:
            {
                $numu = "TRES";
                break;
            }
            case 2:
            {
                $numu = "DOS";
                break;
            }
            case 1:
            {
                $numu = "UN";
                break;
            }
            case 0:
            {
                $numu = "";
                break;
            }
        }
        return $numu;
    }
    public static function decena($numdero){

        if ($numdero >= 90 && $numdero <= 99)
        {
            $numd = "NOVENTA ";
            if ($numdero > 90)
                $numd = $numd."Y ".(GenericClass::unidad($numdero - 90));
        }
        else if ($numdero >= 80 && $numdero <= 89)
        {
            $numd = "OCHENTA ";
            if ($numdero > 80)
                $numd = $numd."Y ".(GenericClass::unidad($numdero - 80));
        }
        else if ($numdero >= 70 && $numdero <= 79)
        {
            $numd = "SETENTA ";
            if ($numdero > 70)
                $numd = $numd."Y ".(GenericClass::unidad($numdero - 70));
        }
        else if ($numdero >= 60 && $numdero <= 69)
        {
            $numd = "SESENTA ";
            if ($numdero > 60)
                $numd = $numd."Y ".(GenericClass::unidad($numdero - 60));
        }
        else if ($numdero >= 50 && $numdero <= 59)
        {
            $numd = "CINCUENTA ";
            if ($numdero > 50)
                $numd = $numd."Y ".(GenericClass::unidad($numdero - 50));
        }
        else if ($numdero >= 40 && $numdero <= 49)
        {
            $numd = "CUARENTA ";
            if ($numdero > 40)
                $numd = $numd."Y ".(GenericClass::unidad($numdero - 40));
        }
        else if ($numdero >= 30 && $numdero <= 39)
        {
            $numd = "TREINTA ";
            if ($numdero > 30)
                $numd = $numd."Y ".(GenericClass::unidad($numdero - 30));
        }
        else if ($numdero >= 20 && $numdero <= 29)
        {
            if ($numdero == 20)
                $numd = "VEINTE ";
            else
                $numd = "VEINTI".(GenericClass::unidad($numdero - 20));
        }
        else if ($numdero >= 10 && $numdero <= 19)
        {
            switch ($numdero){
                case 10:
                {
                    $numd = "DIEZ ";
                    break;
                }
                case 11:
                {
                    $numd = "ONCE ";
                    break;
                }
                case 12:
                {
                    $numd = "DOCE ";
                    break;
                }
                case 13:
                {
                    $numd = "TRECE ";
                    break;
                }
                case 14:
                {
                    $numd = "CATORCE ";
                    break;
                }
                case 15:
                {
                    $numd = "QUINCE ";
                    break;
                }
                case 16:
                {
                    $numd = "DIECISEIS ";
                    break;
                }
                case 17:
                {
                    $numd = "DIECISIETE ";
                    break;
                }
                case 18:
                {
                    $numd = "DIECIOCHO ";
                    break;
                }
                case 19:
                {
                    $numd = "DIECINUEVE ";
                    break;
                }
            }
        }
        else
            $numd = GenericClass::unidad($numdero);
        return $numd;
    }
    public static function centena($numc){
        if ($numc >= 100)
        {
            if ($numc >= 900 && $numc <= 999)
            {
                $numce = "NOVECIENTOS ";
                if ($numc > 900)
                    $numce = $numce.(GenericClass::decena($numc - 900));
            }
            else if ($numc >= 800 && $numc <= 899)
            {
                $numce = "OCHOCIENTOS ";
                if ($numc > 800)
                    $numce = $numce.(GenericClass::decena($numc - 800));
            }
            else if ($numc >= 700 && $numc <= 799)
            {
                $numce = "SETECIENTOS ";
                if ($numc > 700)
                    $numce = $numce.(GenericClass::decena($numc - 700));
            }
            else if ($numc >= 600 && $numc <= 699)
            {
                $numce = "SEISCIENTOS ";
                if ($numc > 600)
                    $numce = $numce.(GenericClass::decena($numc - 600));
            }
            else if ($numc >= 500 && $numc <= 599)
            {
                $numce = "QUINIENTOS ";
                if ($numc > 500)
                    $numce = $numce.(GenericClass::decena($numc - 500));
            }
            else if ($numc >= 400 && $numc <= 499)
            {
                $numce = "CUATROCIENTOS ";
                if ($numc > 400)
                    $numce = $numce.(GenericClass::decena($numc - 400));
            }
            else if ($numc >= 300 && $numc <= 399)
            {
                $numce = "TRESCIENTOS ";
                if ($numc > 300)
                    $numce = $numce.(GenericClass::decena($numc - 300));
            }
            else if ($numc >= 200 && $numc <= 299)
            {
                $numce = "DOSCIENTOS ";
                if ($numc > 200)
                    $numce = $numce.(GenericClass::decena($numc - 200));
            }
            else if ($numc >= 100 && $numc <= 199)
            {
                if ($numc == 100)
                    $numce = "CIEN ";
                else
                    $numce = "CIENTO ".(GenericClass::decena($numc - 100));
            }
        }
        else
            $numce = GenericClass::decena($numc);

        return $numce;
    }
    public static function miles($nummero){
        if ($nummero >= 1000 && $nummero < 2000){
            $numm = "MIL ".(GenericClass::centena($nummero%1000));
        }
        if ($nummero >= 2000 && $nummero <10000){
            $numm = GenericClass::unidad(Floor($nummero/1000))." MIL ".(GenericClass::centena($nummero%1000));
        }
        if ($nummero < 1000)
            $numm = GenericClass::centena($nummero);

        return $numm;
    }
    public static function decmiles($numdmero){
        if ($numdmero == 10000)
            $numde = "DIEZ MIL";
        if ($numdmero > 10000 && $numdmero <20000){
            $numde = GenericClass::decena(Floor($numdmero/1000))."MIL ".(GenericClass::centena($numdmero%1000));
        }
        if ($numdmero >= 20000 && $numdmero <100000){
            $numde = GenericClass::decena(Floor($numdmero/1000))." MIL ".(GenericClass::miles($numdmero%1000));
        }
        if ($numdmero < 10000)
            $numde = GenericClass::miles($numdmero);

        return $numde;
    }
    public static function cienmiles($numcmero){
        if ($numcmero == 100000)
            $num_letracm = "CIEN MIL";
        if ($numcmero >= 100000 && $numcmero <1000000){
            $num_letracm = GenericClass::centena(Floor($numcmero/1000))." MIL ".(GenericClass::centena($numcmero%1000));
        }
        if ($numcmero < 100000)
            $num_letracm = GenericClass::decmiles($numcmero);
        return $num_letracm;
    }
    public static function millon($nummiero){
        if ($nummiero >= 1000000 && $nummiero <2000000){
            $num_letramm = "UN MILLON ".(GenericClass::cienmiles($nummiero%1000000));
        }
        if ($nummiero >= 2000000 && $nummiero <10000000){
            $num_letramm = GenericClass::unidad(Floor($nummiero/1000000))." MILLONES ".(GenericClass::cienmiles($nummiero%1000000));
        }
        if ($nummiero < 1000000)
            $num_letramm = GenericClass::cienmiles($nummiero);

        return $num_letramm;
    }
    public static function decmillon($numerodm){
        if ($numerodm == 10000000)
            $num_letradmm = "DIEZ MILLONES";
        if ($numerodm > 10000000 && $numerodm <20000000){
            $num_letradmm = GenericClass::decena(Floor($numerodm/1000000))."MILLONES ".(GenericClass::cienmiles($numerodm%1000000));
        }
        if ($numerodm >= 20000000 && $numerodm <100000000){
            $num_letradmm = GenericClass::decena(Floor($numerodm/1000000))." MILLONES ".(GenericClass::millon($numerodm%1000000));
        }
        if ($numerodm < 10000000)
            $num_letradmm = GenericClass::millon($numerodm);

        return $num_letradmm;
    }
    public static function cienmillon($numcmeros){
        if ($numcmeros == 100000000)
            $num_letracms = "CIEN MILLONES";
        if ($numcmeros >= 100000000 && $numcmeros <1000000000){
            $num_letracms = GenericClass::centena(Floor($numcmeros/1000000))." MILLONES ".(GenericClass::millon($numcmeros%1000000));
        }
        if ($numcmeros < 100000000)
            $num_letracms = GenericClass::decmillon($numcmeros);
        return $num_letracms;
    }
    public static function milmillon($nummierod){
        if ($nummierod >= 1000000000 && $nummierod <2000000000){
            $num_letrammd = "MIL ".(GenericClass::cienmillon($nummierod%1000000000));
        }
        if ($nummierod >= 2000000000 && $nummierod <10000000000){
            $num_letrammd = GenericClass::unidad(Floor($nummierod/1000000000))." MIL ".(GenericClass::cienmillon($nummierod%1000000000));
        }
        if ($nummierod < 1000000000)
            $num_letrammd = GenericClass::cienmillon($nummierod);

        return $num_letrammd;
    }
    public static function generarPDF($pathfilename,$content,$header='',$footer='',$headerspacing=1){
        try {
            $content->render();
            ini_set("memory_limit", -1);
            ini_set('max_execution_time', 0);
            $snappy = new Pdf('"C:\Program Files\wkhtmltopdf\bin\wkhtmltopdf.exe"');

            if (file_exists($pathfilename))
                unlink($pathfilename);
            $snappy->setTemporaryFolder(storage_path());
            $snappy->setOptions(array(
                'header-html' => $header,
                'footer-html' => $footer,
                'header-spacing' => $headerspacing,
                'page-size' => 'Letter',
                'margin-left' => '10',
                'margin-right' => '10',
                'margin-top' => '15',
                'margin-bottom' => '15'
            ));

            $snappy->generateFromHtml($content, $pathfilename);

            return ["success",$pathfilename];
        }
        catch(\Exception $e){
            return ["error","[".$e->getLine()." ".basename($e->getFile())."] ".$e->getMessage()];
        }

    }
    public static function busquedaSortCxc($query, $diccionario, $input)
    {
        $where = "";
        /**/
        foreach ($input as $index => $param) {
            $param = GenericClass::limpiaCadena($param);
            if ($index != "sort" && isset($diccionario[$index])) {
                if (is_array($diccionario[$index])) {
                    $where .= "TRIM(REPLACE(" . $diccionario[$index]["where"] . ",CHAR(10),'')) like TRIM(REPLACE('" . $param . "',CHAR(10),'')) and ";
                } else {
                    $where .= "TRIM(REPLACE(" . $diccionario[$index] . ",CHAR(10),'')) like TRIM(REPLACE('" . $param . "',CHAR(10),'')) and ";
                }
            }
        }
        $where = trim($where, " and ");
        $where = "(" . $where . ")";
        //dd($where);
        if ($where != "()")
            $query->whereRaw($where);
        /**/

        if (isset($input["sort"]) && $input["sort"] != "") {
            $valor = $input["sort"];
            $p = explode("_", $valor);
            if(isset($diccionario[$p[0]])) {
                if (is_array($diccionario[$p[0]])) {
                    $query->orderBy($diccionario[$p[0]]["col"], $p[1]);
                } else {
                    $query->orderBy($diccionario[$p[0]], $p[1]);
                }
            }

        }
        return $query;
    }
    public static function limpiaCadena($cadena)
    {
        $raros = array("\\", "¨", "º", "~",
            "#", "|", "!", '"',
            "·", "$", /*"%",*/ "&", "/",
            "(", ")", "?", "'", "¡",
            "¿", "[", "^", "<code>", "]",
            "+", "}", "{", "¨", "´",
            ">", "<", ";", ":");
        if (is_array($cadena)) {
            foreach ($cadena as $index => $valor) {
                if (is_object($valor)) {
                    foreach ($valor as $i => $v) {
                        $cadena[$index]->$i = str_replace($raros, '', $v);
                    }
                } else
                    $cadena[$index] = str_replace($raros, '', $valor);
            }
        } else if (is_object($cadena)) {
            foreach ($cadena as $index => $valor) {
                $cadena->$index = str_replace($raros, '', $valor);
            }
        } else
            $cadena = str_replace($raros, '', $cadena);

        return $cadena;
    }
    public static function limpiaFilename($cadena,$ext){
        $raros = array("\\", "¨", "º", "~",
            "#", "|", "!", '"',
            "·", "$", "%", "&", "/",
            "?", "'", "¡", " ",
            "¿", "[", "^", "<code>", "]",
            "+", "}", "{", "¨", "´",
            ">", "<", ";", ":", "_", "á", "é", "í", "ó", "ú");
        $cadena = str_replace(".".$ext,"",$cadena);
        $cadena = str_replace($raros, '', $cadena);
        return $cadena.".".$ext;
    }
    public static function ejecutar($comando){

        //file_put_contents("C:\\test.bat",'task:ejecutar --comando='.$comando);
        Artisan::call('task:ejecutar', [
            '--comando' => $comando
        ]);
    }
    public static function certificado(){
        $certificado = Certificado::orderby("id","desc")->first();
        if($certificado){
            return $certificado;
        }
        else{
            return new Certificado();
        }

    }
    public static function storage(){
        $licencia = Auth::user()->licencia_id;
        $path = "C:\\RYVConsultores\\".$licencia;
        return $path;
    }
    public static function getPrefixNamespaces($contents){
        $inicio = 0;
        $namespace = '';
        $namespaces = [];
        for($i=0;$i<strlen($contents);$i++)
        {
            if($contents[$i]=="<"){
                $inicio = 1;
                $namespace = '';
            }
            else if($contents[$i]==" "||$contents[$i]==">"){
                $namespace = '';
                $inicio = 1;
            }
            else if($contents[$i]=="="){
                $namespace = '';
                $inicio = 0;
            }
            else if($contents[$i]==":"){
                $namespace .= $contents[$i];
                $namespace = str_replace("/","",$namespace);
                if(!in_array($namespace,$namespaces)) {
                    if($namespace!=":"&&$namespace!=""&&$namespace!="http:"&&$namespace!="https:"&&(!is_numeric(str_replace(":","",$namespace)))) {
                        $namespaces[] = $namespace;
                    }
                }
                $inicio = 0;
                $namespace = '';
            }
            else if($inicio==1){
                $namespace .= $contents[$i];
            }

        }
        //dd($namespaces);
        return $namespaces;
    }
    public static function getColumnas($tabla){
        return DB::getSchemaBuilder()->getColumnListing($tabla);
        /*
         * <div class="row">
        @foreach(GenericClass::getColumnas("productos") as $columna)
        <div class="form-group col-sm-4">
          |- Form::label('{!! $columna !!}', '{!! $columna !!}'.':') -|
          |- Form::text('{!! $columna !!}', null, ['class' => 'form-control','maxlength'=>255]) -|
        </div>
        @endforeach
    </div>
         * */
    }
    public static function select2Val($valor){
        $partes = explode(" - ",$valor);
        return $partes[0];
    }
    public static function makeZip($filenames,$filenamesDst,$folder,$namezip)
    {

        $fzip = $folder."\\".$namezip;
        $path = base64_encode($fzip);
        $f = [];
        $t = [];
        if (file_exists($fzip)) {
            unlink($fzip);
        }
        //SI SON VARIOS ARCHIVOS
        foreach ($filenames as $j=>$file) {
            if (file_exists($file)) {
                if (is_dir($file)) {
                    //SI ES UN FOLDER OBTENER SUS ARCHIVOS
                    $archivos = scandir($file);
                    foreach ($archivos as $archivo) {
                        if ($archivo != "." && $archivo != "..") {
                            $f[] = $file . "\\" . $archivo;
                            $t[] = $filenamesDst[$j]. "\\" . $archivo;
                        }
                    }
                } else {
                    $f[] = $file;
                    $t[] = $filenamesDst[$j];
                }
            }
        }
        if (count($f) > 0) {
            $zip = new \ZipArchive();
            if ($zip->open($fzip, ZIPARCHIVE::CREATE) === true) {
                foreach ($f as $i => $file) {
                    if (file_exists($file)) {
                        $zip->addFile($file, $t[$i]);
                        /*$partes = explode("\\", $file);
                        if ($t[$i] == "dir") {
                            if (count($filenames) > 1) {
                                $zip->addFile($file, $partes[count($partes) - 2] . "\\" . $partes[count($partes) - 1]);
                            } else {
                                $zip->addFile($file, $partes[count($partes) - 1]);
                            }
                        } else {
                            $zip->addFile($file, $partes[count($partes) - 1]);
                        }*/

                    }
                }
                $zip->close();
                return ["success", $path, $namezip];

            } else {
                return ["error", 'Error creando ' . $fzip];
            }
        }
        return ["error", "No hay archivos para descargar"];
    }
    public static function getQuery($query){
        $builder = clone $query;
        $addSlashes = str_replace('?', "'?'", $builder->toSql());
        return vsprintf(str_replace('?', '%s', $addSlashes), $builder->getBindings());
    }
}