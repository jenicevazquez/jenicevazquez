<?php

namespace App\Libraries\Repositories;


use App\Model\Conexion;
use App\Models\Blog\Articulo;
use App\Models\Cliente;
use App\Models\activoFijo;
use App\Alerta;
use App\Models\Archivo;
use App\ConsultaVucem;
use App\Contribuyente;
use App\Ftpdata;
use App\Http\Controllers\HomeController;
use App\Models\Config;
use App\Models\Minimo;
use App\Models\Noticia;
use App\Models\Sistema;
use App\Models\usuario;
use App\Models\Pedimento;
use App\PedimentoUser;
use App\User;
use App\Vucem;
use Illuminate\Http\Request;
use Knp\Snappy\Image;
use Knp\Snappy\Pdf;
use Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpKernel\Exception\UnsupportedMediaTypeHttpException;
use ZipArchive;
use Illuminate\Support\Facades\File;


class GeneralRepository
{

    public static function busquedaSort($query, $diccionario, $input)
    {
        $where = "";
        if (isset($input["q"]) && $input["q"] != "") {
            $input["q"] = GeneralRepository::limpiaCadena($input["q"]);
            foreach ($diccionario as $col) {
                if (is_array($col)) {
                    $where .= "REPLACE(LOWER(" . $col["where"] . "),' ','') like REPLACE(LOWER('%" . $input["q"] . "%'),' ','') or ";
                } else {
                    $where .= "REPLACE(LOWER(" . $col . "),' ','') like REPLACE(LOWER('%" . $input["q"] . "%'),' ','') or ";
                }

            }
            $where = trim($where, " or ");
            $where = "(" . $where . ")";
            if ($where != "()")
                $query->whereRaw($where);
        }
        if (isset($input["sort"]) && $input["sort"] != "") {
            $valor = $input["sort"];
            $p = explode("_", $valor);
            if (is_array($diccionario[$p[0]])) {
                $query->orderBy($diccionario[$p[0]]["col"], $p[1]);
            } else {
                $query->orderBy($diccionario[$p[0]], $p[1]);
            }
        }
        return $query;
    }
    /*Continua construyendo el query buscando los input en el diccionario*/
    /*query es una consulta, diccionario es un array e input un array que viene de un request CXC*/
    public static function busquedaSortCxc($query, $diccionario, $input)
    {
        $where = "";

        /**/
        foreach ($input as $index => $param) {
            $param = GeneralRepository::limpiaCadena($param);
            if ($index != "sort" && isset($diccionario[$index]) && $param!='') {
                if (is_array($diccionario[$index])) {
                    $where .= "REPLACE(LOWER(" . $diccionario[$index]["where"] . "),' ','') like REPLACE(LOWER('%" . $param . "%'),' ','') and ";
                } else {
                    $where .= "REPLACE(LOWER(" . $diccionario[$index] . "),' ','') like REPLACE(LOWER('%" . $param . "%'),' ','') and ";
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
            if (is_array($diccionario[$p[0]])) {
                $query->orderBy($diccionario[$p[0]]["col"], $p[1]);
            } else {
                $query->orderBy($diccionario[$p[0]], $p[1]);
            }

        }
        return $query;
    }
    public static function limpiaFilename($cadena){
        $raros = array("\\", "¨", "º", "~",
            "#", "|", "!", '"',
            "·", "$", "%", "&", "/",
            "?", "'", "¡", " ",
            "¿", "[", "^", "<code>", "]",
            "+", "}", "{", "¨", "´",
            ">", "<", ";", ":", "_", "á", "é", "í", "ó", "ú");
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
    public static function limpiaCadena($cadena)
    {
        $raros = array("\\", "¨", "º", "~",
            "#", "|", "!", '"',
            "·", "$", "%", "&", "/",
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
    /* R E C U R S O S*/
    public static function calculoRecursos($path)
    {
        // -- Seccion D I S C O  ----- //
        $diskTotal = GeneralRepository::getDiskSpace($path);
        $diskFree = GeneralRepository::getDiskSpaceFree($path);
        $diskUsed = $diskTotal -$diskFree;
        $result["diskPerc"] = round(($diskUsed * 100) / $diskTotal, 2);
        // -- Fin seccion D I S C O  ----- //

        // -- Seccion ARCHIVOS  ----- //
        $path = storage_path2('Expediente');
        $fi = new \FilesystemIterator($path, \FilesystemIterator::SKIP_DOTS);
        $nodos = iterator_count($fi);
        $result["files"] = $nodos;
        // -- Fin seccion ARCHIVOS  ----- //

        $result["disktotal"] = GeneralRepository::convert($diskTotal);
        $result["diskused"] = GeneralRepository::convert($diskUsed);
        $result["diskfree"] = GeneralRepository::convert($diskFree);
        //dd($result);
        return $result;

    }
    public static function convert($size)
    {
        $unit = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');
        return @round($size / pow(1024, ($i = floor(log($size, 1024)))), 2) . ' ' . $unit[$i];
        //return @round($size/pow(1024,($i=floor(log($size,1024)))),2);
    }
    public static function verPDF($pathShow)
    {
        return Response::make(file_get_contents($pathShow), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $pathShow . '"',
        ]);
    }
    public static function tamano_archivo($nombre_archivo, $decimales = 2)
    {
        $peso = filesize($nombre_archivo); // obtenemos su peso en bytes
        $clase = array(" Bytes", " KB", " MB", " GB", " TB");
        return round($peso / pow(1024, ($i = floor(log($peso, 1024)))), $decimales) . $clase[$i];
    }
    public static function digitos($num, $digitos = 3)
    {
        $num = (string)$num;
        $largo = strlen($num);

        $numStr = "";
        if ($largo < $digitos) {
            $v = $digitos - $largo;
            for ($i = 0; $i < $v; $i++) {
                $numStr .= "0";
            }
            $numStr .= $num;
        } elseif ($largo > $digitos) {
            $numStr = substr($num, -$digitos);
        } else {
            $numStr = $num;
        }
        return $numStr;
    }
    public static function get_page_mod_time()
    {
        $incls = get_included_files();
        $incls = array_filter($incls, "is_file");
        $mod_times = array_map('filemtime', $incls);
        $mod_time = max($mod_times);

        return $mod_time;
    }
    public static function dirTree($dir)
    {
        $arDir = [];

        if (is_dir($dir)) {
            $arDir = scandir($dir);
        }

        return $arDir;

    }
    public static function modTree($dir)
    {
        $arDir = [];
        $fmDir = [];

        if (is_dir($dir)) {
            $arDir = scandir($dir);
        }
        foreach ($arDir as $a) {
            $fmDir[] = date("d/m/Y H:i", filemtime($dir . '/' . $a));
        }
        return $fmDir;

    }
    public static function printTree($array, $dir, $f, $t)
    {
        $dir = base64_decode($dir);
        $dir = str_replace(storage_path2(), "", $dir);
        echo "<table class='table table-hovered'>";
        echo "<tr><th>Nombre</th><th>Descripcion</th><th>Modificado</th>";

        foreach ($array as $key => $value) {
            $partes = explode(".", $value);
            $file = base64_encode($dir . "/" . $value);

            if ($value != '.' && $value != '..') {
                if (count($partes) > 1) {

                    $tipo = (isset($t[$key]->minimo)) ? $t[$key]->minimo : "";
                    /*echo "<div class='col-xs-12 col-sm-6 file'>
                            <div class='col-xs-12 col-sm-6'>
                                <i class='fa fa-square-o fa-2x mychk' data-value='".$file."'></i>
                                <a onclick='verPDF(\"".url("ver/".$file)."\",false,\"".$value."\")'>
                                <i class='fa fa-file-text fa-2x'></i> ".$value."</a>
                            </div>
                            <div class='col-xs-12 col-sm-6'>".$f[$key]."</div>
                                </div>";*/
                    echo "<tr class='file'><td><i class='fa fa-square-o fa-2x mychk' data-value='" . $file . "'></i>&nbsp;
                            <a onclick='verPDF(\"" . url("ver/" . $file) . "\",false,\"" . $value . "\")'>
                                <i class='fa fa-file-text'></i> " . $value . "</a>
                                
                                </td><td><a data-datos='" . json_encode($t[$key]) . "' href='javascript:void(0)' onclick='editarTipo(this)' >" . $tipo . "</a></td><td>" . $f[$key] . "</td></tr>";
                } else {
                    /*echo "<div class='col-xs-12 col-sm-6 file'>
                            <div class='col-xs-12 col-sm-6'><i class='fa fa-square-o fa-2x mychk' data-value='".$file."'></i>
                                <a href='".url("home/".$file)."'><i class='fa fa-folder fa-2x'></i> ".$value."</a></div>
                            <div class='col-xs-12 col-sm-6'>".$f[$key]."</div>

                                </div>";*/
                    echo "<tr class='file'><td><i class='fa fa-square-o fa-2x mychk' data-value='" . $file . "'></i>&nbsp;
                            <a href='" . url("home/" . $file) . "'>
                                <i class='fa fa-folder'></i> " . $value . "</a>
                                </td><td>" . $f[$key] . "</td><td></td></tr>";
                }
            }

        }
        echo "</table>";

    }
    public static function delete_files($target)
    {

        $isfolder = is_dir($target);

        if (file_exists($target)) {

            if ($isfolder) {
                $files = scandir($target);

                foreach ($files as $file) {
                    if($file!='.' && $file!='..') {
                        GeneralRepository::delete_files($target."\\".$file);
                    }
                }

                chmod($target, 0755);
                rmdir($target);

            }
            else{
                unlink($target);
            }
        }





    }
    public static function xml2array($xmlObject, $out = array())
    {
        foreach ((array)$xmlObject as $index => $node)
            $out[$index] = (is_object($node)) ? xml2array($node) : $node;

        return $out;
    }
    public static function copy_directory($src, $dst)
    {
        $dir = opendir($src);


        while (false !== ($file = readdir($dir))) {
            if (($file != '.') && ($file != '..')) {
                if (is_dir($src . '/' . $file)) {

                    GeneralRepository::copy_directory($src . '/' . $file, $dst . '/' . $file);
                } else {
                    copy($src . '/' . $file, $dst . '/' . $file);
                }
            }
        }
        closedir($dir);
    }
    public static function getUsuarios()
    {

        $usuarios = DB::table("users")->orderby("name")->lists("name", "id");
        return $usuarios;
    }
    public static function getUsers()
    {

        $usuarios = User::orderby("name")->get();
        return $usuarios;
    }
    public static function user()
    {
        $user = Auth::user()->id;
        $user = DB::table("users")
            ->where('users.id', $user)
            ->first();
        return $user;
    }
    public static function paginado($coleccion, $q = "")
    {
        $dominio = "http://" . $_SERVER['HTTP_HOST'];

        /**/

        $total = $coleccion->total();
        $currentPage = $coleccion->currentPage();
        $currentPerpage = $coleccion->perPage();
        $start = (($currentPage - 1) * $currentPerpage) + 1;
        $finish = ($start + $currentPerpage) - 1;
        $finish = ($finish > $total) ? $total : $finish;
        $pages = ceil($total / $currentPerpage);
        $int = ceil($total / 10);
        $currentPerpage = ($pages == 1) ? $total : $currentPerpage;
        $perpage = '';


        if ($total > 0) {
            /*$perpage = '<div class="perpagecontent pagination">Resultados por pagina <select class="perpage">';

            for ($i = $int; $i <= $total; $i += $int) {

                $s = ($currentPerpage == $i) ? 'selected' : '';
                $perpage .= '<option ' . $s . ' >' . $i . '</option>';

            }
            $perpage .= '</select>';*/
            //$perpage .= '<div class="infopagination">' . $start . '-' . $finish . ' de ' . $total . ' registros | pag. ' . $currentPage . '/' . $pages . '</div>';
            $perpage .= '<div class="infopagination">' . $start . '-' . $finish . ' de ' . $total . ' registros </div>';
            $perpage .= '</div>';
        }

        /**/

        if ($q != "")
            $paginado = str_replace($dominio, url()->current(), $coleccion->appends($q)->render());
        else
            $paginado = str_replace($dominio, url()->current(), $coleccion->render());

        $result = $paginado . $perpage;

        return $result;
    }
    public static function makeRequest($url, $request)
    {
        $headers = array(
            "Content-type: text/xml; charset=UTF-8",
            "Accept: text/xml",
            "Cache-Control: no-cache",
            "Pragma: no-cache",
            "Content-length: " . strlen($request) . "");
        $soap = curl_init();
        curl_setopt($soap, CURLOPT_URL, $url);

        curl_setopt($soap, CURLOPT_FAILONERROR, 1);
        curl_setopt($soap, CURLOPT_FOLLOWLOCATION, 1);

        curl_setopt($soap, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($soap, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($soap, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($soap, CURLOPT_CONNECTTIMEOUT ,0);
        curl_setopt($soap, CURLOPT_TIMEOUT, 600);
        curl_setopt($soap, CURLOPT_POST, true);

        curl_setopt($soap, CURLOPT_POSTFIELDS, $request);
        curl_setopt($soap, CURLOPT_HTTPHEADER, $headers);
        $result = curl_exec($soap);
        if(curl_error($soap)!="") {
            $e = curl_error($soap);
            var_dump($e);
            GeneralRepository::publicar($e);
            if($e=="The requested URL returned error: 404 Not Found")
                die();
        }
        curl_close($soap);
        return $result;
    }
    public static function makeRequest2($url, $request)
    {
        $headers = array(
            "Content-type: text/xml; charset=UTF-8",
            "Accept: text/xml",
            "Cache-Control: no-cache",
            "Pragma: no-cache",
            "Content-length: " . strlen($request) . "");
        $soap = curl_init();
        curl_setopt($soap, CURLOPT_URL, $url);

        curl_setopt($soap, CURLOPT_FAILONERROR, 1);
        curl_setopt($soap, CURLOPT_FOLLOWLOCATION, 1);

        curl_setopt($soap, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($soap, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($soap, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($soap, CURLOPT_CONNECTTIMEOUT ,0);
        curl_setopt($soap, CURLOPT_TIMEOUT, 600);
        curl_setopt($soap, CURLOPT_POST, true);

        curl_setopt($soap, CURLOPT_POSTFIELDS, $request);
        curl_setopt($soap, CURLOPT_HTTPHEADER, $headers);
        $result = curl_exec($soap);
        $e="";
        if(curl_error($soap)!="") {
            $e = curl_error($soap);
            var_dump($e);
        }
        curl_close($soap);
        return [$result,$e];
    }
    public static function checkFolder($aduana, $patente, $pedimento, $expedientePath)
    {
        //OBTENER NOMBRE DEL FOLDER CORRESPONDIENTE//
        $adu = substr($aduana, 0, 2);
        $folder = $adu . '-' . $patente . '-' . $pedimento;
        //SI NO EXISTE EL FOLDER, SE CREA//
        if (!file_exists($expedientePath . $folder)) {
            mkdir($expedientePath . $folder, 0777, true);
        }
        return $folder;
    }
    /*FUNCIONES PARA PROCESAR ZIPS*/
    public static function descomprimir($file, $destination, $user, $del = true)
    {
        set_time_limit(0);
        $zip = new ZipArchive;
        $res = $zip->open($file);

        if ($res === TRUE) {
            GeneralRepository::delete_files($destination);
            $zip->extractTo($destination);
            $zip->close();
            if ($del)
                unlink($file);
            return true;
        } else {
            return false;
        }
    }
    public static function convertEstado($key)
    {
        $estados = array("0" => "Aguascalientes",
            "1" => "Baja California",
            "2" => "Baja California Sur",
            "3" => "Campeche",
            "4" => "CDMX",
            "5" => "Chiapas",
            "6" => "Chihuahua",
            "7" => "Coahuila",
            "8" => "Colima",
            "9" => "Durango",
            "10" => "Guanajuato",
            "11" => "Guerrero",
            "12" => "Hidalgo",
            "13" => "Jalisco",
            "14" => "Michoacán",
            "15" => "Morelos",
            "16" => "Nayarit",
            "17" => "Nuevo León",
            "18" => "Oaxaca",
            "19" => "Puebla",
            "20" => "Querétaro",
            "21" => "Quintana Roo",
            "22" => "San Luis Potosí",
            "23" => "Sinaloa",
            "24" => "Sonora",
            "25" => "Tabasco",
            "26" => "Tamaulipas",
            "27" => "Tlaxcala",
            "28" => "Veracruz",
            "29" => "Yucatán",
            "30" => "Zacatecas");
        if ($key != NULL) {
            $key = $estados[$key];
        }
        return $key;
    }
    public static function sendmail($name, $to, $subject, $registro, $source)
    {
        $data = array(
            'name' => $name,
            'registros' => $registro,
            'pathToImage' => asset('img/logo2.png')
        );
        Mail::send("templates.$source", $data, function ($message) use ($to, $subject) {
            $message->from('expediente@aduanasoft.com.mx', 'Expediente Electrónico')
                ->to($to)
                ->subject($subject);
        });
        return "Your email has been sent successfully";
    }
    public static function getpais($clave){
        $pais = DB::table("paises")->where("CLAVEM3",$clave)->pluck("DESC_E");
        return $pais;
    }
    public static function obtenerFechas(){
        $fecha1 = date('Y-m-d');
        $fecha1 = strtotime('-1 day', strtotime($fecha1));
        $fecha1 = date('Y-m-d', $fecha1);
        $fecha2 = strtotime('-5 year', strtotime($fecha1));
        $fecha2 = date('Y', $fecha2);
        $fecha2 = $fecha2.'-01-01';
        $fecha = date('Y-m-d');
        $debug = false;

        if ($debug) {
            $fecha1 = $fecha;
            $fecha2 = $fecha;
        }
        return [$fecha1,$fecha2];
    }
    public static function dateToString($date){
        $date = explode("-", $date);
        $meses = array(
            "1" => "Enero",
            "2" => "Febrero",
            "3" => "Marzo",
            "4" => "Abril",
            "5" => "Mayo",
            "6" => "Junio",
            "7" => "Julio",
            "8" => "Agosto",
            "9" => "Septiembre",
            "10" => "Octubre",
            "11" => "Noviembre",
            "12" => "Diciembre"
        );

        return  $meses[$date[1]] ." del $date[0]";
    }
    public static function getTC(){
        /*LEER XML DOF*/
        //$anobii = simplexml_load_file('http://utileria.aduanasoft.com/tipoCambio.xml');

        //$tc = GeneralRepository::decodificar($anobii->item->valor);
        $tc='';
        return $tc;
    }
    public static function codificar($dato) {
        $resultado = $dato;
        $arrayLetras = array('R', 'Y', 'V', 'C');
        $limite = count($arrayLetras) - 1;
        $num = mt_rand(0, $limite);
        for ($i = 0; $i <= $num; $i++) {
            $resultado = base64_encode($resultado);
        }
        $resultado = $resultado . '+' . $arrayLetras[$num].'+'.time();
        $resultado = base64_encode($resultado);
        return $resultado;
    }
    public static function decodificar($dato) {
        $resultado = base64_decode($dato);
        $partes = explode('+', $resultado);
        $resultado = $partes[0];
        $letra = $partes[1];
        $arrayLetras = array('R', 'Y', 'V', 'C');
        $i = array_search($letra,$arrayLetras);
        for ($j = 0; $j <= $i; $j++) {
            $resultado = base64_decode($resultado);
        }
        return $resultado;
    }
    public static function generarPDF($pathfilename,$content,$header='',$footer='',$headerspacing=1){
        ini_set("memory_limit","850M");
        ini_set('max_execution_time', 0);
        $snappy = new Pdf('"C:\Program Files\wkhtmltopdf\bin\wkhtmltopdf.exe"');

        if(file_exists($pathfilename))
            unlink($pathfilename);
        $snappy->setTemporaryFolder(storage_path());
        $snappy->setOptions(array(
            'header-html' => $header,
            'footer-html' => $footer,
            'header-spacing' => $headerspacing
        ));
        $snappy->generateFromHtml($content, $pathfilename);

        return Response::make(file_get_contents($pathfilename),200,[
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'.$pathfilename.'"',
        ]);
    }
    public static function generarImage($pathfilename,$content,$format){
        ini_set("memory_limit","850M");
        ini_set('max_execution_time', 0);
        $snappy = new Image('"C:\Program Files\wkhtmltopdf\bin\wkhtmltoimage.exe"');

        if(file_exists($pathfilename))
            unlink($pathfilename);
        $snappy->setTemporaryFolder(storage_path());
        $snappy->setOptions(array(
            'format' => $format
        ));
        $snappy->generateFromHtml($content, $pathfilename);

        return Response::make(file_get_contents($pathfilename),200,[
            'Content-Type' => 'image/'.$format,
            'Content-Disposition' => 'inline; filename="'.$pathfilename.'"',
        ]);
    }
    public static function generarImageDownload($pathfilename,$content,$format){
        ini_set("memory_limit","850M");
        ini_set('max_execution_time', 0);
        $snappy = new Image('"C:\Program Files\wkhtmltopdf\bin\wkhtmltoimage.exe"');

        if(file_exists($pathfilename))
            unlink($pathfilename);
        $snappy->setTemporaryFolder(storage_path());
        $snappy->setOptions(array(
            'format' => $format
        ));
        $snappy->generateFromHtml($content, $pathfilename);

        return Response::make(file_get_contents($pathfilename),200,[
            'Content-Type' => 'image/'.$format,
            'Content-Disposition' => 'attachment; filename="'.$pathfilename.'"',
        ]);
    }
    public static function listar_directorios_ruta($ruta){
        // abrir un directorio y listarlo recursivo
        if (is_dir($ruta)) {
            if ($dh = opendir($ruta)) {
                while (($file = readdir($dh)) !== false) {
                    //esta línea la utilizaríamos si queremos listar todo lo que hay en el directorio
                    //mostraría tanto archivos como directorios
                    if($file!="." && $file!="..") {

                        if (is_dir($ruta . $file)) {
                            //solo si el archivo es un directorio, distinto que "." y ".."
                            echo "<br>-> $ruta$file";
                            GeneralRepository::listar_directorios_ruta($ruta . $file . "/");
                        }
                        else{
                            echo "<br> $file: " . date("Y-m-d H:i:s", filemtime($ruta . $file));
                        }
                    }
                }
                closedir($dh);
            }
        }else
            echo "<br>No es ruta valida";
    }
    public static function printDocumentacionXML($elemento,$salida="",$bread="",$cont=0){
        $cont++;

        $bread .= ' > ';
        $bread .= isset($elemento["@attributes"])? $elemento["@attributes"]["name"][0]:'';
        $bread = trim($bread,' > ');
        //var_dump($bread);
        /*if($cont==4)
            dd($bread);*/
        if($cont==3)
            $salida .= "<table class='table nivel".$cont."' data-datos='".json_encode($elemento)."'>";
        else
            $salida .= '<table class="table nivel'.$cont.'">';

        $salida .= '<tr>
            <th>'.$bread.'</th>
            <th colspan="2">';
        $salida .= isset($elemento["annotation"])? $elemento["annotation"]["documentation"]:'';
        $salida .= '</th></tr>';

        if(isset($elemento["complexType"])) {
            if(isset($elemento["complexType"]["attribute"])) {
                if(isset($elemento["complexType"]["attribute"]["@attributes"])){
                    $attribute = $elemento["complexType"]["attribute"];
                    $salida = GeneralRepository::printAttribute($attribute,$salida);
                }
                else{
                    foreach ($elemento["complexType"]["attribute"] as $attribute) {
                        $salida = GeneralRepository::printAttribute($attribute,$salida);
                    }
                }
            }
            if(isset($elemento["complexType"]["sequence"])) {
                if(isset($elemento["complexType"]["sequence"]["element"]["@attributes"])){
                    $elementoChildren = $elemento["complexType"]["sequence"]["element"];
                    $salida = GeneralRepository::printDocumentacionXML($elementoChildren, $salida, $bread, $cont);
                }else {
                    foreach ($elemento["complexType"]["sequence"]["element"] as $elementoChildren) {
                        $salida = GeneralRepository::printDocumentacionXML($elementoChildren, $salida, $bread, $cont);
                    }
                }
            }
        }
        $salida .= '</table>';
        /*if($cont==4)
            dd($salida);*/
        return $salida;
    }
    public static function printAttribute($attribute,$salida=""){
        $salida .= '<tr><td>
                            ' . $attribute["@attributes"]["name"][0] . '<br>
                            ' . $attribute["@attributes"]["use"][0] . '
                        </td>
                        <td>';
        $salida .= isset($attribute["@attributes"]["type"]) ? $attribute["@attributes"]["type"][0] : '';
        $salida .= '<br>';
        $salida .= isset($attribute["@attributes"]["fixed"]) ? $attribute["@attributes"]["fixed"][0] : '';
        $salida .= '</td>
                        <td>' . $attribute["annotation"]["documentation"] . '</td>
                    </tr>';
        return $salida;
    }
    public static function unidad($numuero){
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
                $numd = $numd."Y ".(GeneralRepository::unidad($numdero - 90));
        }
        else if ($numdero >= 80 && $numdero <= 89)
        {
            $numd = "OCHENTA ";
            if ($numdero > 80)
                $numd = $numd."Y ".(GeneralRepository::unidad($numdero - 80));
        }
        else if ($numdero >= 70 && $numdero <= 79)
        {
            $numd = "SETENTA ";
            if ($numdero > 70)
                $numd = $numd."Y ".(GeneralRepository::unidad($numdero - 70));
        }
        else if ($numdero >= 60 && $numdero <= 69)
        {
            $numd = "SESENTA ";
            if ($numdero > 60)
                $numd = $numd."Y ".(GeneralRepository::unidad($numdero - 60));
        }
        else if ($numdero >= 50 && $numdero <= 59)
        {
            $numd = "CINCUENTA ";
            if ($numdero > 50)
                $numd = $numd."Y ".(GeneralRepository::unidad($numdero - 50));
        }
        else if ($numdero >= 40 && $numdero <= 49)
        {
            $numd = "CUARENTA ";
            if ($numdero > 40)
                $numd = $numd."Y ".(GeneralRepository::unidad($numdero - 40));
        }
        else if ($numdero >= 30 && $numdero <= 39)
        {
            $numd = "TREINTA ";
            if ($numdero > 30)
                $numd = $numd."Y ".(GeneralRepository::unidad($numdero - 30));
        }
        else if ($numdero >= 20 && $numdero <= 29)
        {
            if ($numdero == 20)
                $numd = "VEINTE ";
            else
                $numd = "VEINTI".(GeneralRepository::unidad($numdero - 20));
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
            $numd = GeneralRepository::unidad($numdero);
        return $numd;
    }
    public static function centena($numc){
        if ($numc >= 100)
        {
            if ($numc >= 900 && $numc <= 999)
            {
                $numce = "NOVECIENTOS ";
                if ($numc > 900)
                    $numce = $numce.(GeneralRepository::decena($numc - 900));
            }
            else if ($numc >= 800 && $numc <= 899)
            {
                $numce = "OCHOCIENTOS ";
                if ($numc > 800)
                    $numce = $numce.(GeneralRepository::decena($numc - 800));
            }
            else if ($numc >= 700 && $numc <= 799)
            {
                $numce = "SETECIENTOS ";
                if ($numc > 700)
                    $numce = $numce.(GeneralRepository::decena($numc - 700));
            }
            else if ($numc >= 600 && $numc <= 699)
            {
                $numce = "SEISCIENTOS ";
                if ($numc > 600)
                    $numce = $numce.(GeneralRepository::decena($numc - 600));
            }
            else if ($numc >= 500 && $numc <= 599)
            {
                $numce = "QUINIENTOS ";
                if ($numc > 500)
                    $numce = $numce.(GeneralRepository::decena($numc - 500));
            }
            else if ($numc >= 400 && $numc <= 499)
            {
                $numce = "CUATROCIENTOS ";
                if ($numc > 400)
                    $numce = $numce.(GeneralRepository::decena($numc - 400));
            }
            else if ($numc >= 300 && $numc <= 399)
            {
                $numce = "TRESCIENTOS ";
                if ($numc > 300)
                    $numce = $numce.(GeneralRepository::decena($numc - 300));
            }
            else if ($numc >= 200 && $numc <= 299)
            {
                $numce = "DOSCIENTOS ";
                if ($numc > 200)
                    $numce = $numce.(GeneralRepository::decena($numc - 200));
            }
            else if ($numc >= 100 && $numc <= 199)
            {
                if ($numc == 100)
                    $numce = "CIEN ";
                else
                    $numce = "CIENTO ".(GeneralRepository::decena($numc - 100));
            }
        }
        else
            $numce = GeneralRepository::decena($numc);

        return $numce;
    }
    public static function miles($nummero){
        if ($nummero >= 1000 && $nummero < 2000){
            $numm = "MIL ".(GeneralRepository::centena($nummero%1000));
        }
        if ($nummero >= 2000 && $nummero <10000){
            $numm = GeneralRepository::unidad(Floor($nummero/1000))." MIL ".(GeneralRepository::centena($nummero%1000));
        }
        if ($nummero < 1000)
            $numm = GeneralRepository::centena($nummero);

        return $numm;
    }
    public static function decmiles($numdmero){
        if ($numdmero == 10000)
            $numde = "DIEZ MIL";
        if ($numdmero > 10000 && $numdmero <20000){
            $numde = GeneralRepository::decena(Floor($numdmero/1000))."MIL ".(GeneralRepository::centena($numdmero%1000));
        }
        if ($numdmero >= 20000 && $numdmero <100000){
            $numde = GeneralRepository::decena(Floor($numdmero/1000))." MIL ".(GeneralRepository::miles($numdmero%1000));
        }
        if ($numdmero < 10000)
            $numde = GeneralRepository::miles($numdmero);

        return $numde;
    }
    public static function cienmiles($numcmero){
        if ($numcmero == 100000)
            $num_letracm = "CIEN MIL";
        if ($numcmero >= 100000 && $numcmero <1000000){
            $num_letracm = GeneralRepository::centena(Floor($numcmero/1000))." MIL ".(GeneralRepository::centena($numcmero%1000));
        }
        if ($numcmero < 100000)
            $num_letracm = GeneralRepository::decmiles($numcmero);
        return $num_letracm;
    }
    public static function millon($nummiero){
        if ($nummiero >= 1000000 && $nummiero <2000000){
            $num_letramm = "UN MILLON ".(GeneralRepository::cienmiles($nummiero%1000000));
        }
        if ($nummiero >= 2000000 && $nummiero <10000000){
            $num_letramm = GeneralRepository::unidad(Floor($nummiero/1000000))." MILLONES ".(GeneralRepository::cienmiles($nummiero%1000000));
        }
        if ($nummiero < 1000000)
            $num_letramm = GeneralRepository::cienmiles($nummiero);

        return $num_letramm;
    }
    public static function decmillon($numerodm){
        if ($numerodm == 10000000)
            $num_letradmm = "DIEZ MILLONES";
        if ($numerodm > 10000000 && $numerodm <20000000){
            $num_letradmm = GeneralRepository::decena(Floor($numerodm/1000000))."MILLONES ".(GeneralRepository::cienmiles($numerodm%1000000));
        }
        if ($numerodm >= 20000000 && $numerodm <100000000){
            $num_letradmm = GeneralRepository::decena(Floor($numerodm/1000000))." MILLONES ".(GeneralRepository::millon($numerodm%1000000));
        }
        if ($numerodm < 10000000)
            $num_letradmm = GeneralRepository::millon($numerodm);

        return $num_letradmm;
    }
    public static function cienmillon($numcmeros){
        if ($numcmeros == 100000000)
            $num_letracms = "CIEN MILLONES";
        if ($numcmeros >= 100000000 && $numcmeros <1000000000){
            $num_letracms = GeneralRepository::centena(Floor($numcmeros/1000000))." MILLONES ".(GeneralRepository::millon($numcmeros%1000000));
        }
        if ($numcmeros < 100000000)
            $num_letracms = GeneralRepository::decmillon($numcmeros);
        return $num_letracms;
    }
    public static function milmillon($nummierod){
        if ($nummierod >= 1000000000 && $nummierod <2000000000){
            $num_letrammd = "MIL ".(GeneralRepository::cienmillon($nummierod%1000000000));
        }
        if ($nummierod >= 2000000000 && $nummierod <10000000000){
            $num_letrammd = GeneralRepository::unidad(Floor($nummierod/1000000000))." MIL ".(GeneralRepository::cienmillon($nummierod%1000000000));
        }
        if ($nummierod < 1000000000)
            $num_letrammd = GeneralRepository::cienmillon($nummierod);

        return $num_letrammd;
    }
    public static function convertir($numero){
        $partes = explode('.',$numero);
        $partes[1] = isset($partes[1])? $partes[1]:'00';
        $numf = GeneralRepository::milmillon($numero);
        return $numf.' PESOS '.$partes[1].'/100 M.N.';
    }
    public static function sendToFront($params=array()){
        $params2 = array(
            "do"        => "serverTalk"
        );
        $params2 = array_merge($params2, $params);
        stream_context_set_default([
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false
            ],
            'http'=>[
                'header'=>'Connection: close\r\n'
            ]
        ]);
        $url = 'https://ryvconsultores.com.mx:3001';
        if(count($params)>0) {
            $string = ArrayToUrl($params2);
            $url .= "?" . $string;
        }
        file_get_contents($url);
    }
    public static function getMemoriaEnUso(){
        $path = "C:\\";

        $size = disk_free_space($path);

        $totalServer = 120;//gb
        $sizeLicencia = 1073741824*$totalServer;

        $sizeTotal = $size;
        $porcentaje = ceil(($size*100)/$sizeLicencia);
        $sizeStr = convert($sizeTotal);


        return [$sizeStr,$totalServer,$porcentaje,convert($size)];
    }
    public static function numeracion($ini,$fin,$zeros=false){
        $result = [];
        for($i=$ini;$i<=$fin;$i++){
            if($zeros&&$i<10){
                $j = '0'.$i;
            }
            else{
                $j = $i;
            }
            $result[$j]=$j;
        }
        return $result;
    }
    public static function getConfig($clave){
        $registro = Config::where("param",$clave)->first();
        if($registro){
            return $registro->valor;
        }
        else{
            return null;
        }
    }
    public static function slack($text,$attach=""){
        $url = 'https://hooks.slack.com/services/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';
        if($attach=="") {
            $postData = '{
              "text": "' . $text . '"
            }';
        }
        else{
            $postData = '{
            "text": "'.$text.'",
            "attachments": '.$attach.'
        }';
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_exec($ch);
        curl_close($ch);
    }
    public static function getFilem($url){
        clearstatcache();
        if(file_exists($_SERVER["DOCUMENT_ROOT"].$url))
            return filemtime($_SERVER["DOCUMENT_ROOT"].$url);
        else
            return 1;
    }
    public static function getCategorias()
    {

        $usuarios = DB::table("articulosCategoria")->orderby("categoria")->lists("categoria", "id");
        return $usuarios;
    }
    public static function getEtiquetas()
    {

        $etiquetas = DB::table("articulosTag")->select("etiqueta")->groupby("etiqueta")->get();
        return $etiquetas;
    }
    public static function getPopulares()
    {

        $etiquetas = Articulo::orderby("visitas","desc")->take(6)->get();
        return $etiquetas;
    }
}
