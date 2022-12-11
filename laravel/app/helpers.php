<?php

function currentUser()
{

    return auth()->user();


}
function descomprimir($file, $destination, $del=true){
    set_time_limit(0);
    $zip = new ZipArchive;
    $res = $zip->open($file);

    if ($res === TRUE) {
        $zip->extractTo($destination);
        $zip->close();
        if($del)
            unlink($file);
        return true;
    } else {
        return false;
    }
}
function procesarFolder($path,$licencia)
{

    set_time_limit(0);
    // app/61/07-9999-600001/
    // app/1/PIN
    $path = str_replace("/","\\",$path);
    $expediente = disco($licencia)."\\Expediente\\".$licencia."\\";
    $folderName = getFolderfromPath($path);

    if (is_dir($path)) {
        $expedientePath = $expediente . $folderName;
        checkandcreatePath($expedientePath);
        copy_directory($path, $expedientePath,false);
        delete_files($path);
        return $folderName;
    }
    return false;
}
function getFolderfromPath($path){
    $path = str_replace("/","\\",$path);
    $partes = explode("\\", $path);
    $folder = $partes[count($partes)-1];
    $partes = explode(".", $folder);
    $folder = $partes[0];
    $folder = str_replace("-","",$folder);
    $length = strlen($folder);
    $pedimento = substr($folder,$length-7,7);
    $aduana = substr($folder,$length-11,4);
    $anio = substr($folder,$length-13,2);
    $folder = $anio.'-'.$aduana.'-'.$pedimento;
    return $folder;
}
function checkandcreatePath($path){
    $path = str_replace("/","\\",$path);
    $partes = explode("\\", $path);

    $cadena = $partes[0];
    foreach($partes as $i=>$parte){
        if($i>0)
            $cadena .= '\\'.$partes[$i];
        if(!is_dir($cadena)){
            mkdir($cadena);
        }
    }
}
function copy_directory($src, $dst,$rewrite=true)
{
    $dir = opendir($src);

    while (false !== ($file = readdir($dir))) {
        if (($file != '.') && ($file != '..') && ($file != 'Thumbs.db')) {
            if (is_dir($src . '/' . $file)) {
                copy_directory($src . '/' . $file, $dst);
            } else {
                if(!$rewrite) {
                    if (!file_exists($dst . '/' . $file)) {
                        copy($src . '/' . $file, $dst . '/' . $file);
                    }
                }
                else{
                    copy($src . '/' . $file, $dst . '/' . $file);
                }
            }
        }
    }
    closedir($dir);
}
function delete_files($target)
{
    $isfolder = is_dir($target);
    if (file_exists($target)) {
        if ($isfolder) {
            $files = scandir($target);
            foreach ($files as $file) {
                if($file!='.' && $file!='..') {
                    delete_files($target."\\".$file);
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
function getInfofromFolder($folderName){
    $partes = explode("-",$folderName);
    $datos["aduana"] = (isset($partes[count($partes)-3]))? $partes[count($partes)-3].'0':'';
    $datos["patente"] = (isset($partes[count($partes)-2]))? $partes[count($partes)-2]:'';
    $datos["pedimento"] = (isset($partes[count($partes)-1]))? $partes[count($partes)-1]:'';
    $anio = substr(date('Y'),0,3).substr($datos["pedimento"],0,1);
    $datos["fechapago"] = $anio."-01-01";
    return $datos;
}
function getPathPedimento($pedimentoData){
    $file = disco($pedimentoData->licencia)."\\Expediente\\".$pedimentoData->licencia."\\".substr($pedimentoData->aduana,0,2)."-".$pedimentoData->patente."-".$pedimentoData->pedimento;
    $file = str_replace("--","",$file);
    return $file;
}
function makeZip($filenames){

    if(is_array($filenames) && count($filenames)>1) {
        //SI SON VARIOS archivos en un array
        $anio = date("Y");
        $mes = date("m");
        $dia = date("d");
        $namezip = $anio . $mes . $dia . ".zip";
    }
    else if(is_array($filenames)){
        //SI solo es uno en array
        $filename = $filenames[0];
        $filename = str_replace("/","\\",$filename);
        $partes = explode("\\",$filename);
        $filename = $partes[count($partes)-1];
        $partes = explode(".",$filename);
        $namezip = $partes[0].".zip";
    }else{
        //si solo es uno
        $filename = $filenames;
        $partes = explode(".",$filenames);
        $namezip = $partes[0].".zip";
        $filenames[] = $filename;
    }

    $fzip = storage_path("app/download/".$namezip);
    $path = base64_encode($fzip);
    $f    = [];
    $t    = [];

    if(file_exists($fzip)){
        unlink($fzip);
    }

    //SI SON VARIOS ARCHIVOS
    foreach ($filenames as $file){
        if(file_exists($file)) {
            if(is_dir($file)){
                //SI ES UN FOLDER OBTENER SUS ARCHIVOS
                $archivos = scandir($file);
                foreach ($archivos as $archivo) {
                    if ($archivo != "." && $archivo != "..") {
                        $f[] = $file . "\\" . $archivo;
                        $t[] = "dir";
                    }
                }
            }else{
                $f[]=$file;
                $t[] = "file";
            }
        }
    }


    if(count($f)>0) {
        $zip = new ZipArchive();
        if ($zip->open($fzip, ZIPARCHIVE::CREATE) === true) {
            foreach ($f as $i=>$file) {
                if (file_exists($file)) {
                    $partes = explode("\\", $file);
                    if($t[$i]=="dir") {
                        if(count($filenames)>1) {
                            $zip->addFile($file, $partes[count($partes) - 2]."\\".$partes[count($partes) - 1]);
                        }
                        else{
                            $zip->addFile($file, $partes[count($partes) - 1]);
                        }
                    }
                    else{
                        $zip->addFile($file, $partes[count($partes) - 1]);
                    }

                }
            }
            $zip->close();
            return ["success",$path, $namezip];

        } else {
            return ["error",'Error creando ' . $fzip];
        }
    }
    return ["error","No hay archivos para descargar"];
}
function getfileStorage($dir){
    $f = $dir;
    if(file_exists($f)) {
        $obj = new \COM('scripting.filesystemobject');
        if (is_object($obj)) {
            $ref = $obj->getfolder($f);
            $size = $ref->size;
            $obj = null;
        } else {
            $size = 0;
        }
    }
    else{
        $size = 0;
    }
    return $size;
}
function publicar($text){
    $url = 'https://hooks.slack.com/services/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';
    /*$postData = '{
        "text": "'.$titulo.'",
        "attachments": [
            {
                "title": "'.$descripcion.'",
                "author_name": "'.$licencia.'"

            }
        ]
    }';*/
    $postData = '{
          "text": "'.$text.'"
        }';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    curl_exec($ch);
    curl_close($ch);
}
function string2xml($result){
    $result = str_replace('ns2:', '', $result);
    $result = str_replace('ns3:', '', $result);
    $result = str_replace('S:', '', $result);
    $xml = simplexml_load_string($result);
    return $xml;
}
function xml2array($xmlObject, $out = array())
{
    foreach ((array)$xmlObject as $index => $node) {

        if(is_object($node)){
            $out[$index] = xml2array($node);
        }
        else if(is_array($node)){
            foreach ($node as $i=>$n){
                $out[$index][$i] = xml2array($n);
            }
        }
        else{
            $out[$index] = trim($node);
        }

    }
    return $out;
}
function convert($size)
{
    $unit = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');
    return @round($size / pow(1024, ($i = floor(log($size, 1024)))), 2) . ' ' . $unit[$i];
    //return @round($size/pow(1024,($i=floor(log($size,1024)))),2);
}
function getMonth($value){
    $meses = ["","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"];
    return $meses[$value];
}
function allMonths(){
    $meses = ["Seleccione un mes","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"];
    return $meses;
}
function decode_camelcase($string){
    $string = preg_replace('/(?<!^)([A-Z])/', '-\\1', $string);
    $string = str_replace("-"," ", $string);
    return ucfirst($string);
}
//function to simulate the left join
function left_join_array($left, $right, $left_join_on, $right_join_on = NULL){
    $final= array();

    if(empty($right_join_on))
        $right_join_on = $left_join_on;

    foreach($left AS $k => $v){
        $final[$k] = $v;
        foreach($right AS $kk => $vv){
            if($v[$left_join_on] == $vv[$right_join_on]){
                foreach($vv AS $key => $val)
                    $final[$k][$key] = $val;
            } else {
                foreach($vv AS $key => $val)
                    $final[$k][$key] = NULL;
            }
        }
    }
    return $final;
}
function ArrayToUrl($array){
    $string = '';
    foreach ($array as $i=>$element){
        if($element!="") {
            $string .= $i . "=" . urlencode($element) . "&";
        }
    }
    $string = trim($string,'&');
    return $string;
}
// Returns used memory (either in percent (without percent sign) or free and overall in bytes)
function getServerMemoryUsage($getPercentage=true)
{
    $memoryTotal = null;
    $memoryFree = null;

    // Get total physical memory (this is in bytes)
    $cmd = "wmic ComputerSystem get TotalPhysicalMemory";
    @exec($cmd, $outputTotalPhysicalMemory);

    // Get free physical memory (this is in kibibytes!)
    $cmd = "wmic OS get FreePhysicalMemory";
    @exec($cmd, $outputFreePhysicalMemory);

    if ($outputTotalPhysicalMemory && $outputFreePhysicalMemory) {
        // Find total value
        foreach ($outputTotalPhysicalMemory as $line) {
            if ($line && preg_match("/^[0-9]+\$/", $line)) {
                $memoryTotal = $line;
                break;
            }
        }

        // Find free value
        foreach ($outputFreePhysicalMemory as $line) {
            if ($line && preg_match("/^[0-9]+\$/", $line)) {
                $memoryFree = $line;
                $memoryFree *= 1024;  // convert from kibibytes to bytes
                break;
            }
        }
    }

    if (is_null($memoryTotal) || is_null($memoryFree)) {
        return null;
    } else {
        if ($getPercentage) {
            return (100 - ($memoryFree * 100 / $memoryTotal));
        } else {
            return array(
                "total" => $memoryTotal,
                "free" => $memoryFree,
            );
        }
    }
}
// Returns server load in percent (just number, without percent sign)
function getServerLoad()
{
    $load = null;

    $wmi = new COM("Winmgmts://");
    $server = $wmi->execquery("SELECT LoadPercentage FROM Win32_Processor");

    $cpu_num = 0;
    $load_total = 0;

    foreach($server as $cpu){
        $cpu_num++;
        $load_total += $cpu->loadpercentage;
    }

    $load = round($load_total/$cpu_num);

    return $load;
}
function fbLikeCount($url){
    $query = "select total_count from link_stat WHERE url ='" . $url ."'";
    $s = file_get_contents("https://api.facebook.com/method/fql.query?query=".
        urlencode($query)."&format=json");
    preg_match("#(\"total_count\"):([0-9]*)#",$s,$ar);
    //dd($ar);
    if(isset($ar[2])) return $ar[2]; else return null;
}
