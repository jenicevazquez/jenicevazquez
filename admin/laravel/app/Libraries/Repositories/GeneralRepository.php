<?php

namespace App\Libraries\Repositories;


use App\Model\Conexion;
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
use App\Models\NoticiaCategoria;
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
    public static function getRamSpace()
    {
        foreach (file('/proc/meminfo') as $ri)
            $m[strtok($ri, ':')] = strtok('');
        return $m;
    }

    public static function getDiskSpace($path)
    {
        return disk_total_space($path);
    }

    public static function getDiskSpaceFree($path)
    {
        return disk_free_space($path);
    }

    /***********************************By Jenice ♥ **************************************************/


    /*Saca un array con los totales de un result, es decir de un objeto de registros*/
    public static function getTotalesFromResult($result)
    {
        $totales = [];
        $aux = "";

        foreach ($result as $i => $row) {
            foreach ($row as $index => $valor) {
                if ($i == 0) {
                    $totales[$index] = 0;
                }
                $aux .= " - " . $index . " : " . $valor;
                $valor = (is_null($valor)) ? 0 : $valor;
                if (is_numeric($valor) && $index != "id") {
                    $totales[$index] = (float)$totales[$index] + (float)$valor;
                } else {
                    $totales[$index] = $valor;
                }

            }
        }
        //dd($aux);
        return $totales;
    }
    /*Continua construyendo el query buscando los input en el diccionario*/
    /*query es una consulta, diccionario es un array e input un array que viene de un request*/
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

    public static function validarVista($vista)
    {

        $pos = strpos($vista, ".block_exception");
        return $pos;
        if ($pos) {
            return 0;
        } else {
            return 1;
        }
    }

    public static function registro($funcion, $variables, $tabla, $id)
    {
        $dias = 7;
        $fecha = date('Y-m-j');
        $nuevafecha = strtotime('-' . $dias . ' day', strtotime($fecha));
        $nuevafecha = date('Y-m-j', $nuevafecha);
        DB::table("Registro")->where("fecha", "<=", $nuevafecha)->delete();
        DB::table("Registro")->insert(array(
            "fecha" => DB::raw("NOW()"),
            "funcion" => $funcion,
            "usuario" => Auth::user()->id,
            "variables" => $variables,
            "tabla" => $tabla,
            "idtabla" => $id
        ));
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

    public static function FUNC_sizeDomainQuota($quota, $path)
    {

        function obsah($adr, &$totalquota, &$dir, &$size, &$item)
        {
            $novalidar = array(
                "conf", ".s.PGSQL.5432"
            );

            $dp = OpenDir($adr);

            do {

                $itm = ReadDir($dp);

                if (Is_Dir("$adr/$itm") && ($itm != ".") && ($itm != "..") && ($itm != "")) {
                    $item[] = $itm;
                    obsah("$adr/$itm", $totalquota, $dir, $size, $item);

                    $dir++;
                } elseif (($itm != ".") && ($itm != "..") && ($itm != "")) {
                    if (!in_array($itm, $novalidar)) {
                        $size = $size + FileSize("$adr/$itm");

                    }
                    $totalquota++;

                }

            } while ($itm != false);

            CloseDir($dp);

        }

        //obsah($path, $totalquota, $dir, $size, $item);
        //dd($item);

        $freeA = round($size / 1048576, 2);

        $freeB = $quota - $freeA;

        $datosQuote["usado"] = $freeA;
        $datosQuote["quota"] = $quota;
        $datosQuote["libre"] = $freeB;
        $datosQuote["archivos"] = $totalquota;
        $datosQuote["carpetas"] = $dir;

        return $datosQuote;
    }

    public static function empresa()
    {
        $empresa = DB::table("empresas")->first();
        return $empresa;
    }

    public static function verPDF($pathShow)
    {
        return Response::make(file_get_contents($pathShow), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $pathShow . '"',
        ]);
    }

    public static function existe($tabla, $datos, $id = 0)
    {
        $query = DB::table($tabla);
        foreach ($datos as $i => $dato) {
            $query->where($i, $dato);
        }
        if ($id != 0) {
            $query->where("id", "!=", $id);
        }
        if (Schema::hasColumn($tabla, 'deleted_at')) ;
        {
            $query->where('deleted_at', null);
        }
        $existe = $query->count();
        if ($existe > 0)
            return true;
        else
            return false;
    }

    public static function alertas($id = 0)
    {
        $licencia = Auth::user()->licencia_id;
        $query = DB::table("pedimentos")->where("porcentaje", "<", 100)->where("licencia", $licencia);
        $min = DB::table("minimos_user")->leftjoin("minimos","minimos.id","=","minimos_user.minimo_id")
            ->where("licencia_id",$licencia);
        $min2 = DB::table("minimos_user")->leftjoin("minimos","minimos.id","=","minimos_user.minimo_id")
            ->where("licencia_id",$licencia);;
        $operacion1 = ""; $operacion2 = "";

        if($min->where('minimos.operacion',1)->where('clave','Todos')->pluck('clave') == null){
            $operacion1 = " AND clave IN (SELECT minimos.clave FROM minimos_user
				JOIN minimos ON minimos.id = minimos_user.minimo_id WHERE minimos_user.licencia_id = $licencia 
				and minimos.operacion = 1)";
        }
        if($min2->where('minimos.operacion',2)->where('clave','Todos')->pluck('clave') == null){
            $operacion2 = " AND clave IN (SELECT minimos.clave FROM minimos_user
				JOIN minimos ON minimos.id = minimos_user.minimo_id WHERE minimos_user.licencia_id = $licencia 
				and minimos.operacion = 2)";
        }
        $q = DB::table("pedimentos")->where("porcentaje", "<", 100)->where("licencia", $licencia);

        if ($id != 0)
            $q->where("pedimentos.id", $id);
        $alertas["cont"] = $q->whereRaw(DB::raw(" ((operacion = 1 $operacion1) OR (operacion = 2 $operacion2) ) "))
            ->select('pedimentos.id', 'patente', 'pedimento', 'porcentaje')->count();

        //$query = DB::table("pedimentos")->where("porcentaje", "<", 100)->where("licencia", $licencia);
        if ($id != 0)
            $query->where("pedimentos.id", $id);
        $pedimentos = $query->whereRaw(DB::raw(" ((operacion = 1 $operacion1) OR (operacion = 2 $operacion2) ) "))
            ->orderby('pedimentos.created_at')->take(10)->get();

        $alertas["documentos"] = $pedimentos;
        $contador = 0;

        foreach ($pedimentos as $i => $pedimento) {
            $minimos = DB::table("minimos_user")->leftjoin("minimos", "minimos.id","=","minimos_user.minimo_id")
                ->where("minimos_user.licencia_id", $licencia)->where("operacion",
                    DB::raw("(SELECT operacion FROM pedimentos WHERE id = $pedimento->id)"))
                ->whereRaw(DB::raw("( (minimos.clave = (SELECT clave FROM pedimentos WHERE id = $pedimento->id) OR minimos.clave = 'Todos') )"))
                ->select("minimos_user.minimo_id")->get();
            $minimos = array_column(json_decode(json_encode($minimos), True), "minimo_id");

            $archivos = DB::table("archivos")
                ->leftjoin("pedimentos", "archivos.pedimento_id", "=", "pedimentos.id")
                ->where("pedimentos.licencia", $licencia)->where("pedimentos.id", $pedimento->id)
                ->select("archivos.minimo_id")->get();
            $archivos = array_column(json_decode(json_encode($archivos), True), "minimo_id");
            $faltan = array_diff($minimos, $archivos);
            $alertas["documentos"][$i]->faltan = $faltan;
            //dd($minimos, $archivos, $faltan, $alertas);
            $contador += count($faltan);
        }
        $alertas["cont"] = $contador==0 ? 0 : $alertas["cont"];
        //dd($alertas);
        return $alertas;
    }
    public static function minimoFaltante($id){
        $name = DB::table("minimos")->where("id", $id)->pluck("nombre");
        return $name;
    }
    public static function ftpdata()
    {
        $ftpdata = DB::table("ftpdata")->where("creado", Auth::user()->id)->where("procesado", 0)->count();
        return $ftpdata;
    }

    public static function getAlertas()
    {
        $childs = GeneralRepository::getChildsPedimentos(Auth::user()->id);

        $query = DB::table("pedimentos")->where("porcentaje", "<", 100);
        if (Auth::user()->role_id != 1)
            $query->wherein("pedimentos.id", $childs);

        $pedimentos = $query->select('pedimentos.id', 'patente', 'pedimento', 'porcentaje')->distinct()->get();

        $contar = count($pedimentos);

        Session::put('alertas', $contar);
        return $pedimentos;

    }

    public static function setPorcentaje($id)
    {
        $user = Auth::user()->id;
        $licencia = Auth::user()->licencia_id;
        $totalminimos = DB::table("minimos_user")->join("minimos", "minimos.id", "=", "minimos_user.minimo_id")
            ->where("minimos_user.licencia_id", $licencia)
            ->where("minimos.operacion", DB::raw("(SELECT operacion FROM pedimentos WHERE id = $id)"))
            ->whereRaw(DB::raw("( (minimos.clave = (SELECT clave FROM pedimentos WHERe id = $id) OR minimos.clave = 'Todos') )"))
            ->count();

        $archivos = DB::table("archivos")->join("minimos_user", "archivos.minimo_id", "=", "minimos_user.minimo_id")
            ->join("minimos","minimos.id","=","minimos_user.minimo_id")
            ->where("archivos.pedimento_id", $id)->where("minimos.operacion", DB::raw("(SELECT operacion FROM pedimentos WHERE id = $id)"))
            ->whereRaw(DB::raw("( (minimos.clave = (SELECT clave FROM pedimentos WHERe id = $id) OR minimos.clave = 'Todos') )"))
            ->count();
        $porcentaje = ($totalminimos > 0) ? ($archivos * 100) / $totalminimos : 0;

        $pedimento = Pedimento::find($id);
        //dd($pedimento);
        $pedimento->fill(array(
            "porcentaje" => $porcentaje
        ));
        $pedimento->save();

    }

    public static function getAgent($user)
    {
        $agente = DB::table("users")->where("id", $user)->first();

        if ($agente->parent == 0) {
            return $agente->id;
        }
        GeneralRepository::getAgent($agente->parent);
    }

    public static function hasRelationshipsMsg($array)
    {
        $resp = "";
        foreach ($array as $i => $c) {
            if ($c > 0) {
                $resp .= " tiene " . $i . ",";
            }
        }
        if ($resp != "") {
            $resp = trim($resp, ', ');
            $resp = ucfirst($resp);
            return "No se borró el elemento: " . $resp . ".";
        } else
            return false;
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

    public static function breadcrum($dir)
    {

        $dir = base64_decode($dir);
        $dir = str_replace(storage_path2(), "", $dir);

        $parts = explode("/", $dir);
        $res = '<ol style="float: left" class="breadcrumb">';
        $res .= '<i title="Seleccionar todo" class=\'fa fa-square-o fa-2x chkAll\' style="float: left; cursor: pointer;" onclick="selectAll(this)"></i> ';
        $path = '';
        foreach ($parts as $i => $p) {
            $path .= $p . "/";
            if ($p == "Expediente")
                $p = '<i class="fa fa-home"></i>';
            if ($i == count($parts) - 1)
                $res .= '<li class="active">' . $p . '</li>';
            else {
                $code = base64_encode($path);
                $res .= '<li><a href="' . $code . '">' . $p . '</a></li>';
            }

        }

        $res .= '</ol>';
        echo $res;
    }

    //PATH EN EL QUE INICIA
    public static function root()
    {

        $rol = Auth::user()->role_id;
        $id = Auth::user()->id;
        $agente = Auth::user()->agente;

        switch ($rol) {
            case 1:
                $path = "/" . $id;
                break;
            case 2:
                $path = "/" . $agente . "/" . $id;
                break;
            default:
                $path = "";
        }
        $path = "";
        return $path;
    }

    public static function savePath()
    {

        $id = Auth::user()->id;
        $agente = Auth::user()->agente;

        $path = "/" . $agente . "/" . $id;
        return $path;
    }

    public static function datosFile($file)
    {
        $file = str_replace("/", "", $file);
        $partes = explode("-", $file);
        if (count($partes) == 4)
            return ["aduana" => $partes[1] . "0", "patente" => $partes[2], "pedimento" => $partes[3]];
        else
            return "error";
    }

    public static function getRFCXml($file)
    {

        if (file_exists($file)) {
            $xml = simplexml_load_file($file);
            $rfc = [];

            $ns = $xml->getNamespaces(true);
            $soap = $xml->children($ns['soapenv']);

            //RFC USERNAME
            $res = $soap->Header->children($ns['wsse']);
            $res = $res->Security->children($ns['wsse']);
            $res = $res->UsernameToken->children($ns['wsse']);
            $res = GeneralRepository::xml2array($res);
            $rfc[] = $res["Username"];

            //RFC EMISOR
            $res = $soap->Body->children($ns['oxml']);
            $res = $res->solicitarRecibirCoveServicio->children($ns['oxml']);
            $res = $res->comprobantes->children($ns['oxml']);
            $res = $res->emisor->children($ns['oxml']);
            $res = $res->identificacion;
            $res = GeneralRepository::xml2array($res);
            $rfc[] = $res[0];

            //RFC EMISOR
            $res = $soap->Body->children($ns['oxml']);
            $res = $res->solicitarRecibirCoveServicio->children($ns['oxml']);
            $res = $res->comprobantes->children($ns['oxml']);
            $res = $res->destinatario->children($ns['oxml']);
            $res = $res->identificacion;
            $res = GeneralRepository::xml2array($res);
            $rfc[] = $res[0];

            //PATENTE
            $res = $soap->Body->children($ns['oxml']);
            $res = $res->solicitarRecibirCoveServicio->children($ns['oxml']);
            $res = $res->comprobantes->children($ns['oxml']);
            $res = $res->patenteAduanal;
            $res = GeneralRepository::xml2array($res);
            $patente = $res[0];

            //tipo operacion
            $res = $soap->Body->children($ns['oxml']);
            $res = $res->solicitarRecibirCoveServicio->children($ns['oxml']);
            $res = $res->comprobantes->children($ns['oxml']);
            $res = $res->tipoOperacion;
            $res = GeneralRepository::xml2array($res);
            $operacion = $res[0];
            $operacion = ($operacion == "TOCE.IMP") ? 1 : 2;

            return [$rfc, $operacion];

        } else {

            exit('Error abriendo xml.');

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

    public static function minimos()
    {
        $licencia = Auth::user()->licencia_id;
        $minimos = Minimo::select(
            "minimos.id", "minimos.nombre", "minimos.archivo", "minimos.clave", "minimos.operacion",
            DB::raw("ISNULL(minimos_user.orden,99) AS numero")
        )
            ->leftjoin("minimos_user", "minimos_user.minimo_id", "=", "minimos.id")
            ->where("minimos.created_by", $licencia)
            ->orderby("numero")
            ->get();

        return $minimos;
    }

    public static function sminimos()
    {
        $minimos = Minimo::select(
            "minimos.id", "minimos.nombre", "minimos.archivo",
            DB::raw("minimos.id AS numero")
        )->where("created_by",Auth::user()->licencia_id)->orderby("numero")->lists("nombre", "id");
        $minimos[0] = "Otros";
        return $minimos;
    }

    public static function user()
    {
        $user = Auth::user()->id;
        $user = DB::table("users")
            ->leftjoin("roles", "roles.id", "=", "users.role_id")
            ->where('users.id', $user)
            ->select("users.*", "roles.role as perfil")->first();
        return $user;
    }
    public static function getUserName($id){
        $usuario = DB::table("users")->where("id", $id)->pluck("nombre");
        return $usuario;
    }

    public static function getRoles()
    {
        $roles = DB::table("roles")->get();
        return $roles;
    }
    public static function getUsuariosRows()
    {
        $roles = User::where("licencia_id",Auth::user()->licencia_id)->get();
        return $roles;
    }
    public static function sRoles()
    {
        $roles = DB::table("roles")->where("licencia",Auth::user()->licencia_id)->lists("role","id");
        return $roles;
    }

    public static function getChilds($user, $result = [])
    {
        $result[] = $user;
        $childs = DB::table("users")->where("parent", $user)->get();
        foreach ($childs as $child) {
            $result = GeneralRepository::getChilds($child->id, $result);
        }
        return $result;
    }

    public static function getChildsPedimentos($user)
    {

        $childs = GeneralRepository::getChilds($user);
        $rfc = [];
        foreach ($childs as $child) {
            $rfc[] = DB::table("users")->where("id", $child)->pluck("rfc");
        }

        $pedimentos = DB::table("pedimentos_users")->wherein("pedimentos_users.rfc", $rfc)->lists("pedimento_id");

        return $pedimentos;
    }

    public static function getChildsRFC($user)
    {

        $childs = GeneralRepository::getChilds($user);
        $rfc = [];
        foreach ($childs as $child) {
            $rfc[] = DB::table("users")->where("id", $child)->pluck("rfc");
        }


        return $rfc;
    }

    public static function sRFC()
    {
        $rfcs = DB::table("users")->orderby("rfc")->lists("rfc", "id");
        return $rfcs;
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

    public static function listarPedimentos($user, $pass, $aduana, $patente, $fecha)
    {
        $data = array(
            "funcion" => "listarPedimentos",
            "usuario" => $user,
            "aduana" => $aduana,
            "fecha" => $fecha
        );
        $pedimentos = [];
        /*$d = ConsultaVucem::where($data)->first();
        if(isset($d->estado) && $d->estado==1){
            return ["estado"=>0, "resultado"=>"Ya registrado","pedimentos"=>$pedimentos];
        }*/
        $url = "https://www.ventanillaunica.gob.mx/ventanilla-ws-pedimentos/ListarPedimentosService?wsdl";
        $xml = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:lis="http://www.ventanillaunica.gob.mx/pedimentos/ws/oxml/listarpedimentos">
                    <soapenv:Header>
                        <wsse:Security soapenv:mustUnderstand="1" xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
                            <wsse:UsernameToken>
                                <wsse:Username>' . $user . '</wsse:Username>
                                <wsse:Password Type="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-username-token-profile-1.0#PasswordText">' . $pass . '</wsse:Password>
                            </wsse:UsernameToken>
                        </wsse:Security>
                    </soapenv:Header>   
                    <soapenv:Body>
                        <lis:consultarPedimentosPeticion>
                            <lis:peticion>
                                <lis:aduana>' . $aduana . '</lis:aduana>
                                <lis:patente>' . $patente . '</lis:patente>
                                <lis:pedimento/>
                                <lis:eDocumentCove/>
                                <lis:rfc/>
                                <lis:contenedor/>
                                <lis:guia/>
                                <lis:fechaInicio>' . $fecha . '</lis:fechaInicio>
                                <lis:fechaFin>' . $fecha . '</lis:fechaFin>
                            </lis:peticion>
                        </lis:consultarPedimentosPeticion>
                    </soapenv:Body>
                </soapenv:Envelope>';


        $result = GeneralRepository::makeRequest($url, $xml);

        if (!$result) {
            $estado = 0;

        } else {

            $xml = simplexml_load_string($result);

            $ns = $xml->getNamespaces(true);
            $soap = $xml->children($ns['S']);


            //ERROR
            $res = $soap->Body->children($ns['ns2']);
            $res = $res->consultarPedimentosRespuesta->children($ns['ns3']);
            $tieneError = $res->tieneError;

            if ($tieneError == "true") {
                $result = $res->error->mensaje;
                $estado = ($result == "No hay información para la búsqueda solicitada") ? 1 : 0;
            } else {

                //PEDIMENTO
                $res = $soap->Body->children($ns['ns2']);
                $res = $res->consultarPedimentosRespuesta->children($ns['ns2']);
                $res = (array)$res;
                $res = (array)$res["pedimento"];
                $estado = 1;

                foreach ($res as $i => $r) {
                    $rr = (string)$res[$i]->numeroDocumentoAgente;
                    $pedimentos[] = $rr;
                }

            }


        }

        $consulta = ConsultaVucem::firstOrNew($data);
        $consulta->estado = $estado;
        $consulta->respuesta = $result;
        $consulta->save();
        return ["estado" => $estado, "resultado" => $result, "pedimentos" => $pedimentos, "aduana" => $aduana];
    }

    public static function pedimentoCompleto($user, $pass, $aduana, $patente, $pedimento, $folder)
    {
        $data = array(
            "funcion" => "pedimentoCompleto",
            "usuario" => $user,
            "aduana" => $aduana,
            "pedimento" => $pedimento
        );
        $url = "https://www.ventanillaunica.gob.mx/ventanilla-ws-pedimentos/ConsultarPedimentoCompletoService?wsdl";
        $xml = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:con="http://www.ventanillaunica.gob.mx/pedimentos/ws/oxml/consultarpedimentocompleto" xmlns:com="http://www.ventanillaunica.gob.mx/pedimentos/ws/oxml/comunes">
                   <soapenv:Header>
                        <wsse:Security soapenv:mustUnderstand="1" xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
                            <wsse:UsernameToken>
                                <wsse:Username>' . $user . '</wsse:Username>
                                <wsse:Password Type="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-username-token-profile-1.0#PasswordText">' . $pass . '</wsse:Password>
                            </wsse:UsernameToken>
                        </wsse:Security>
                    </soapenv:Header>   
                   <soapenv:Body>
                      <con:consultarPedimentoCompletoPeticion>
                         <con:peticion>
                            <com:aduana>' . $aduana . '</com:aduana>
                            <com:patente>' . $patente . '</com:patente>
                            <com:pedimento>' . $pedimento . '</com:pedimento>
                         </con:peticion>
                      </con:consultarPedimentoCompletoPeticion>
                   </soapenv:Body>
                </soapenv:Envelope>';

        $result = GeneralRepository::makeRequest($url, $xml);


        /*$result = '<S:Envelope xmlns:S="http://schemas.xmlsoap.org/soap/envelope/">
   <S:Header>
      <wsse:Security S:mustUnderstand="1" xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
         <wsu:Timestamp xmlns:wsu="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-utility-1.0.xsd">
            <wsu:Created>2017-08-17T21:02:12Z</wsu:Created>
            <wsu:Expires>2017-08-17T21:03:12Z</wsu:Expires>
         </wsu:Timestamp>
      </wsse:Security>
   </S:Header>
   <S:Body>
      <ns2:consultarPedimentoCompletoRespuesta xmlns="http://www.ventanillaunica.gob.mx/pedimentos/ws/oxml/comunes" xmlns:ns2="http://www.ventanillaunica.gob.mx/pedimentos/ws/oxml/consultarpedimentocompleto" xmlns:ns3="http://www.ventanillaunica.gob.mx/common/ws/oxml/respuesta" xmlns:ns4="http://www.ventanillaunica.gob.mx/common/ws/oxml/resolucion" xmlns:ns5="http://www.ventanillaunica.gob.mx/common/ws/oxml/respuestatra" xmlns:ns6="http://www.ventanillaunica.gob.mx/common/ws/oxml/dictamen" xmlns:ns7="http://www.ventanillaunica.gob.mx/common/ws/oxml/observacion" xmlns:ns8="http://www.ventanillaunica.gob.mx/common/ws/oxml/requisito" xmlns:ns9="http://www.ventanillaunica.gob.mx/common/ws/oxml/opinion">
         <ns3:tieneError>false</ns3:tieneError>
         <ns2:numeroOperacion>3809656183</ns2:numeroOperacion>
         <ns2:pedimento>
            <ns2:pedimento>2004748</ns2:pedimento>
            <ns2:encabezado>
               <ns2:tipoOperacion>
                  <ns2:clave>2</ns2:clave>
                  <ns2:descripcion>Exportacion</ns2:descripcion>
               </ns2:tipoOperacion>
               <ns2:claveDocumento>
                  <ns2:clave>RT</ns2:clave>
                  <ns2:descripcion>RETORNO DE MERCANCIA ELABORADAS TRANSFORMADAS O REPARADAS POR IMMEX</ns2:descripcion>
               </ns2:claveDocumento>
               <ns2:destino>
                  <ns2:clave>7</ns2:clave>
                  <ns2:descripcion>FRANJA FRONTERIZA NORTE</ns2:descripcion>
               </ns2:destino>
               <ns2:aduanaEntradaSalida>
                  <ns2:clave>71</ns2:clave>
                  <ns2:descripcion>PUENTE INTERNAL. ZARAGOZA-ISLETA, CHIH.</ns2:descripcion>
               </ns2:aduanaEntradaSalida>
               <ns2:tipoCambio>12.82990</ns2:tipoCambio>
               <ns2:pesoBruto>1204.410</ns2:pesoBruto>
               <ns2:medioTrasnporteSalida>
                  <ns2:clave>7</ns2:clave>
                  <ns2:descripcion>CARRETERO</ns2:descripcion>
               </ns2:medioTrasnporteSalida>
               <ns2:medioTrasnporteArribo>
                  <ns2:clave>7</ns2:clave>
                  <ns2:descripcion>CARRETERO</ns2:descripcion>
               </ns2:medioTrasnporteArribo>
               <ns2:medioTrasnporteEntrada>
                  <ns2:clave>7</ns2:clave>
                  <ns2:descripcion>CARRETERO</ns2:descripcion>
               </ns2:medioTrasnporteEntrada>
               <ns2:curpApoderadomandatario>MAGR600701HCHRRD05</ns2:curpApoderadomandatario>
               <ns2:rfcAgenteAduanalSocFactura>RAA041014JA2</ns2:rfcAgenteAduanalSocFactura>
               <ns2:valorAduanalTotal>0.00</ns2:valorAduanalTotal>
               <ns2:valorComercialTotal>333754.00</ns2:valorComercialTotal>
            </ns2:encabezado>
            <ns2:importadorExportador>
               <ns2:rfc>TME9909095F7</ns2:rfc>
               <ns2:razonSocial>TORO COMPANY DE MEXICO S. DE R.L. DE C.V.</ns2:razonSocial>
               <ns2:domicilio>
                  <ns2:calle>BLVD.  INDEPENDENCIA, COL PARQUE IND. LAS AMERICAS</ns2:calle>
                  <ns2:numeroExterior>2159</ns2:numeroExterior>
                  <ns2:ciudadMunicipio>CD. JUAREZ</ns2:ciudadMunicipio>
                  <ns2:codigoPostal>32695</ns2:codigoPostal>
               </ns2:domicilio>
               <ns2:seguros>0.00</ns2:seguros>
               <ns2:fletes>0.00</ns2:fletes>
               <ns2:embalajes>0.00</ns2:embalajes>
               <ns2:incrementables>0.00</ns2:incrementables>
               <ns2:aaduanaDespacho>
                  <ns2:clave>71</ns2:clave>
                  <ns2:descripcion>PUENTE INTERNAL. ZARAGOZA-ISLETA, CHIH.</ns2:descripcion>
               </ns2:aaduanaDespacho>
               <ns2:fechas>
                  <ns2:fecha>2012-10-15-05:00</ns2:fecha>
                  <ns2:tipo>
                     <ns2:clave>5</ns2:clave>
                     <ns2:descripcion>FECHA DE PRESENTACION</ns2:descripcion>
                  </ns2:tipo>
               </ns2:fechas>
               <ns2:fechas>
                  <ns2:fecha>2012-10-22-05:00</ns2:fecha>
                  <ns2:tipo>
                     <ns2:clave>2</ns2:clave>
                     <ns2:descripcion>FECHA DE PAGO DE LAS CONTRIBUCIONES</ns2:descripcion>
                  </ns2:tipo>
               </ns2:fechas>
               <ns2:efectivo>244.00</ns2:efectivo>
               <ns2:otros>2250.00</ns2:otros>
               <ns2:total>2494.00</ns2:total>
               <ns2:pais>
                  <clave>MEX</clave>
                  <descripcion>MEXICO (ESTADOS UNIDOS MEXICANOS)</descripcion>
               </ns2:pais>
            </ns2:importadorExportador>
            <ns2:tasas>
               <ns2:contribucion>
                  <ns2:clave>1</ns2:clave>
                  <ns2:descripcion>DTA</ns2:descripcion>
               </ns2:contribucion>
               <ns2:tipoTasa>
                  <clave>4</clave>
                  <descripcion>ESPECIFICO (CUOTA FIJA) DTA</descripcion>
               </ns2:tipoTasa>
               <ns2:tasaAplicable>250.0000000000</ns2:tasaAplicable>
               <ns2:formaPago>
                  <clave>9</clave>
                  <descripcion>EXENTO DE PAGO</descripcion>
               </ns2:formaPago>
               <ns2:importe>2250.00</ns2:importe>
            </ns2:tasas>
            <ns2:tasas>
               <ns2:contribucion>
                  <ns2:clave>15</ns2:clave>
                  <ns2:descripcion>PREVALIDAAAA</ns2:descripcion>
               </ns2:contribucion>
               <ns2:tipoTasa>
                  <clave>2</clave>
                  <descripcion>ESPECIFICO</descripcion>
               </ns2:tipoTasa>
               <ns2:tasaAplicable>210.0000000000</ns2:tasaAplicable>
               <ns2:formaPago>
                  <clave>0</clave>
                  <descripcion>EFECTIVO</descripcion>
               </ns2:formaPago>
               <ns2:importe>244.00</ns2:importe>
            </ns2:tasas>
            <ns2:identificadores>
               <ns2:identificadores>
                  <claveIdentificador>
                     <clave>PC</clave>
                     <descripcion>PEDIMENTO CONSOLIDADO</descripcion>
                  </claveIdentificador>
               </ns2:identificadores>
               <ns2:identificadores>
                  <claveIdentificador>
                     <clave>MS</clave>
                     <descripcion>ACTIVIDADES DE MAQUILADORAS DE SERVICIOS</descripcion>
                  </claveIdentificador>
                  <complemento1>5</complemento1>
               </ns2:identificadores>
               <ns2:identificadores>
                  <claveIdentificador>
                     <clave>IM</clave>
                     <descripcion>AUTORIZACION DE EMPRESA CON PROGRAMA IMMEX</descripcion>
                  </claveIdentificador>
                  <complemento1>23022006</complemento1>
               </ns2:identificadores>
               <ns2:identificadores>
                  <claveIdentificador>
                     <clave>ST</clave>
                     <descripcion>OPERACION SUJETAS AL ART. 303 DEL TLCAN.</descripcion>
                  </claveIdentificador>
                  <complemento1>22</complemento1>
               </ns2:identificadores>
               <ns2:identificadores>
                  <claveIdentificador>
                     <clave>RC</clave>
                     <descripcion>REMESAS DE CONSOLIDADO</descripcion>
                  </claveIdentificador>
                  <complemento1>1-9</complemento1>
               </ns2:identificadores>
               <ns2:identificadores>
                  <claveIdentificador>
                     <clave>IC</clave>
                     <descripcion>IMPORTADOR CERTIFICADO</descripcion>
                  </claveIdentificador>
                  <complemento1>B</complemento1>
               </ns2:identificadores>
            </ns2:identificadores>
            <ns2:partidas>7</ns2:partidas>
            <ns2:partidas>4</ns2:partidas>
            <ns2:partidas>3</ns2:partidas>
            <ns2:partidas>6</ns2:partidas>
            <ns2:partidas>1</ns2:partidas>
            <ns2:partidas>2</ns2:partidas>
            <ns2:partidas>8</ns2:partidas>
            <ns2:partidas>5</ns2:partidas>
         </ns2:pedimento>
      </ns2:consultarPedimentoCompletoRespuesta>
   </S:Body>
</S:Envelope>';*/


        if (!$result) {
            $estado = 0;
        } else {

            $operacion = '';
            $partidas = [];
            $estado = 0;

            $xml = simplexml_load_string($result);
            $ns = $xml->getNamespaces(true);
            $soap = $xml->children($ns['S']);

            //ERROR
            $res = $soap->Body->children($ns['ns2']);

            if (isset($res->consultarPedimentoCompletoRespuesta)) {
                $res = $res->consultarPedimentoCompletoRespuesta->children($ns['ns3']);
                $tieneError = $res->tieneError;


                if ($tieneError == "true") {
                    $result = $res->error->mensaje;
                    $estado = ($result == "No hay información para la búsqueda solicitada") ? 1 : 0;
                } else {

                    //NUMERO DE OPERACION
                    $res = $soap->Body->children($ns['ns2']);
                    $res = $res->consultarPedimentoCompletoRespuesta->children($ns['ns2']);
                    $res = $res->numeroOperacion[0];
                    $operacion = (string)$res;

                    //NUMERO DE operacion
                    $res = $soap->Body->children($ns['ns2']);
                    $res = $res->consultarPedimentoCompletoRespuesta->children($ns['ns2']);
                    $res = $res->pedimento->children($ns['ns2']);
                    $res = $res->encabezado->tipoOperacion;
                    $tipooperacion = ((string)$res == "Importacion") ? 1 : 2;

                    //CLAVE
                    $res = $soap->Body->children($ns['ns2']);
                    $res = $res->consultarPedimentoCompletoRespuesta->children($ns['ns2']);
                    $res = $res->pedimento->children($ns['ns2']);
                    $res = (isset($res->encabezado->claveDocumento->clave)) ? $res->encabezado->claveDocumento->clave : '';
                    $clave = (string)$res;

                    //IMPORTADOR
                    $res = $soap->Body->children($ns['ns2']);
                    $res = $res->consultarPedimentoCompletoRespuesta->children($ns['ns2']);
                    $res = $res->pedimento->children($ns['ns2']);
                    $res = $res->importadorExportador->rfc;
                    $contribuyente = (string)$res;

                    $us = DB::table("users")->where("rfc", $contribuyente)->first();

                    //PAGO
                    $res = $soap->Body->children($ns['ns2']);
                    $res = $res->consultarPedimentoCompletoRespuesta->children($ns['ns2']);
                    $res = $res->pedimento->children($ns['ns2']);
                    $res = $res->importadorExportador->children($ns['ns2']);

                    $fecha = '';
                    $i = 0;
                    while (isset($res->fechas[$i])) {
                        $f = (string)$res->fechas[$i]->tipo->clave;

                        if ($f == '2') {
                            $res = $res->fechas[$i]->fecha;
                            $fecha = (string)$res;
                        }
                        $i++;
                    }

                    //PARTIDAS
                    $res = $soap->Body->children($ns['ns2']);

                    $res = $res->consultarPedimentoCompletoRespuesta->children($ns['ns2']);

                    $res = $res->pedimento;

                    $i = 0;

                    while (isset($res->partidas[$i])) {
                        $partidas[] = (string)$res->partidas[$i];
                        $i++;
                    }


                    $datosXML = array(
                        "aduana" => $aduana,
                        "patente" => $patente,
                        "pedimento" => $pedimento,
                        "operacion" => $tipooperacion,
                        "clave" => $clave,
                        "fechapago" => $fecha,
                        "contribuyente" => $us
                    );

                    $pedi = Pedimento::where("aduana", $aduana)->where("patente", $patente)->where("pedimento", $pedimento)->first();
                    if (count($pedi) == 0) {
                        $pedi = Pedimento::create($datosXML);
                    } else {
                        $pedi->fill($datosXML);
                        $pedi->save();
                    }

                    GeneralRepository::pedimentoRFC($pedi->id, Auth::user()->name);
                    GeneralRepository::pedimentoRFC($pedi->id, $contribuyente);

                    file_put_contents(storage_path2() . '/Expediente/'.$pedi->licencia.'/' . $folder . "/VU_" . $pedimento . ".xml", $result);

                    $estado = 1;

                }
            }


            $consulta = ConsultaVucem::firstOrNew($data);

            $consulta->estado = $estado;
            $consulta->respuesta = $result;
            $consulta->save();
            $pedi = Pedimento::where("aduana", $aduana)->where("patente", $patente)->where("pedimento", $pedimento)->first();

            return [$operacion, $partidas, $pedi->id, $result];

        }
    }

    public static function estadoPedimento($user, $pass, $aduana, $patente, $pedimento, $operacion, $folder)
    {
        $data = array(
            "funcion" => "estadoPedimento",
            "usuario" => $user,
            "aduana" => $aduana,
            "pedimento" => $pedimento
        );
        $url = "https://www.ventanillaunica.gob.mx/ventanilla-ws-pedimentos/ConsultarEstadoPedimentosService?wsdl";
        $xml = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:con="http://www.ventanillaunica.gob.mx/pedimentos/ws/oxml/consultarestadopedimentos" xmlns:com="http://www.ventanillaunica.gob.mx/pedimentos/ws/oxml/comunes">
               <soapenv:Header>
                    <wsse:Security soapenv:mustUnderstand="1" xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
                        <wsse:UsernameToken>
                            <wsse:Username>' . $user . '</wsse:Username>
                            <wsse:Password Type="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-username-token-profile-1.0#PasswordText">' . $pass . '</wsse:Password>
                        </wsse:UsernameToken>
                    </wsse:Security>
                </soapenv:Header>   
               <soapenv:Body>
                  <con:consultarEstadoPedimentosPeticion>
                     <con:numeroOperacion>' . $operacion . '</con:numeroOperacion>
                     <con:peticion>
                        <com:aduana>' . $aduana . '</com:aduana>
                        <com:patente>' . $patente . '</com:patente>
                        <com:pedimento>' . $pedimento . '</com:pedimento>
                     </con:peticion>
                  </con:consultarEstadoPedimentosPeticion>
               </soapenv:Body>
            </soapenv:Envelope>';

        $result = GeneralRepository::makeRequest($url, $xml);

        if (!$result) {
            $estado = 0;
        } else {

            //GUARDAR XML
            file_put_contents(storage_path2() . '/Expediente/' . $folder . "/VU_ESTADO_" . $pedimento . ".xml", $result);
            $estado = 1;


        }
        $consulta = ConsultaVucem::firstOrNew($data);
        $consulta->estado = $estado;
        $consulta->respuesta = $result;
        $consulta->save();
    }

    public static function consultaRemesas($user, $pass, $aduana, $patente, $pedimento, $operacion, $folder)
    {
        $data = array(
            "funcion" => "consultaRemesas",
            "usuario" => $user,
            "aduana" => $aduana,
            "pedimento" => $pedimento
        );
        $url = "https://www.ventanillaunica.gob.mx/ventanilla-ws-pedimentos/ConsultarRemesasService?wsdl";
        $xml = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:con="http://www.ventanillaunica.gob.mx/pedimentos/ws/oxml/consultarremesas" xmlns:com="http://www.ventanillaunica.gob.mx/pedimentos/ws/oxml/comunes">
               <soapenv:Header>
                    <wsse:Security soapenv:mustUnderstand="1" xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
                        <wsse:UsernameToken>
                            <wsse:Username>' . $user . '</wsse:Username>
                            <wsse:Password Type="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-username-token-profile-1.0#PasswordText">' . $pass . '</wsse:Password>
                        </wsse:UsernameToken>
                    </wsse:Security>
                </soapenv:Header>
               <soapenv:Body>
                  <con:consultarRemesasPeticion>
                     <con:numeroOperacion>' . $operacion . '</con:numeroOperacion>
                     <con:peticion>
                        <com:aduana>' . $aduana . '</com:aduana>
                        <com:patente>' . $patente . '</com:patente>
                        <com:pedimento>' . $pedimento . '</com:pedimento>
                     </con:peticion>
                  </con:consultarRemesasPeticion>
               </soapenv:Body>
            </soapenv:Envelope>';

        $result = GeneralRepository::makeRequest($url, $xml);

        if (!$result) {
            $estado = 0;
        } else {
            $estado = 1;
            //GUARDAR XML
            file_put_contents(storage_path2() . '/Expediente/' . $folder . "/VU_REMESA_" . $pedimento . ".xml", $result);

        }
        $consulta = ConsultaVucem::firstOrNew($data);
        $consulta->estado = $estado;
        $consulta->respuesta = $result;
        $consulta->save();
    }

    public static function consultaPartida($user, $pass, $aduana, $patente, $pedimento, $operacion, $partida, $folder)
    {
        $data = array(
            "funcion" => "pedimentoCompleto",
            "usuario" => $user,
            "aduana" => $aduana,
            "pedimento" => $pedimento,
            "partida" => $partida
        );
        $url = "https://www.ventanillaunica.gob.mx/ventanilla-ws-pedimentos/ConsultarPartidaService?wsdl";
        $xml = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:con="http://www.ventanillaunica.gob.mx/pedimentos/ws/oxml/consultarpartida" xmlns:com="http://www.ventanillaunica.gob.mx/pedimentos/ws/oxml/comunes">
               <soapenv:Header>
                    <wsse:Security soapenv:mustUnderstand="1" xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
                        <wsse:UsernameToken>
                            <wsse:Username>' . $user . '</wsse:Username>
                            <wsse:Password Type="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-username-token-profile-1.0#PasswordText">' . $pass . '</wsse:Password>
                        </wsse:UsernameToken>
                    </wsse:Security>
                </soapenv:Header>   
               <soapenv:Body>
                  <con:consultarPartidaPeticion>
                     <con:peticion>
                        <com:aduana>' . $aduana . '</com:aduana>
                        <com:patente>' . $patente . '</com:patente>
                        <com:pedimento>' . $pedimento . '</com:pedimento>
                        <con:numeroOperacion>' . $operacion . '</con:numeroOperacion>
                        <con:numeroPartida>' . $partida . '</con:numeroPartida>
                     </con:peticion>
                  </con:consultarPartidaPeticion>
               </soapenv:Body>
            </soapenv:Envelope>';

        $result = GeneralRepository::makeRequest($url, $xml);

        if (!$result) {
            $estado = 0;
        } else {
            $estado = 1;
            $p = $partida + 1;
            //GUARDAR XML
            file_put_contents(storage_path2() . "/Expediente/" . $folder . "/VU_PARTIDA_" . $pedimento . "-" . $p . ".xml", $result);


        }
        $consulta = ConsultaVucem::firstOrNew($data);
        $consulta->estado = $estado;
        $consulta->respuesta = $result;
        $consulta->save();
    }

    public static function roles()
    {
        $roles = DB::table("roles")->lists("role", "id");
        return $roles;
    }

    public static function vucem()
    {
        $roles = DB::connection("expediente")->table("vucem")->get();
        return $roles;
    }

    public static function aduanas()
    {
        $roles = DB::connection("expediente")->table("aduanas")->get();
        return $roles;
    }

    public static function getAduanas()
    {
        $roles = DB::connection("expediente")->table("aduanas")->select("seccion", DB::raw("seccion+' - '+nombre as nombre"))->lists("nombre", "seccion");
        return $roles;
    }

    public static function getClaves()
    {
        $roles = DB::connection("expediente")->table("clavepedimentos")->select("clave", DB::raw("clave+' - '+descripcion as nombre"))->lists("nombre", "clave");
        return $roles;
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
    public static function getPass($user)
    {
        $datos = Vucem::where("usuario", $user)->pluck("pass");
        return $datos;
    }

    public static function porcentajevu($idpedimento, $user = '')
    {
        $existe = DB::table("listadoPedimentos")->where("id_pedimento", $idpedimento)->count();
        if($existe>0) {

            $total = 3;
            $total += DB::table("listadoPartidas")->where("id_pedimento", $idpedimento)->count();
            $total += DB::table("listadoCoves")->where("id_pedimento", $idpedimento)->where("documento", "LIKE", "COVE%")->count();
            $total += DB::table("listadoEdocuments")->where("id_pedimento", $idpedimento)->count();

            $cont = (DB::table("listadoPedimentos")->where("id_pedimento", $idpedimento)->where("completo", 1)->count() > 0) ? 1 : 0;
            $cont += (DB::table("listadoPedimentos")->where("id_pedimento", $idpedimento)->where("remesas", 1)->count() > 0) ? 1 : 0;
            $cont += (DB::table("listadoPedimentos")->where("id_pedimento", $idpedimento)->where("estado", 1)->count() > 0) ? 1 : 0;
            $cont += DB::table("listadoPartidas")->where("id_pedimento", $idpedimento)->where("completo", 1)->count();
            $cont += DB::table("listadoCoves")->where("documento", "LIKE", "COVE%")->where("id_pedimento", $idpedimento)->where("completo", 1)->count();
            $cont += DB::table("listadoEdocuments")->where("id_pedimento", $idpedimento)->where("completo", 1)->count();

            $size = DB::table("archivos")->where("pedimento_id", $idpedimento)->sum("filesize");

            $p = round(($cont * 100) / $total);
            try {
                DB::table("pedimentos")->where("id", $idpedimento)->update(array("vu" => $p, "filesize" => $size, "updated_by" => $user));
            } catch (\Exception $e) {
                return;
            }
        }

    }
    public static function estatusvu($idpedimento)
    {
        $existe = DB::table("listadoPedimentos")->where("id_pedimento", $idpedimento)->count();
        if($existe>0) {

            $cont = (DB::table("listadoPedimentos")->where("id_pedimento", $idpedimento)->wherein("completo", [0,2])->count() > 0) ? 1 : 0;
            $cont += (DB::table("listadoPedimentos")->where("id_pedimento", $idpedimento)->wherein("remesas", [0,2])->count() > 0) ? 1 : 0;
            $cont += (DB::table("listadoPedimentos")->where("id_pedimento", $idpedimento)->wherein("estado", [0,2])->count() > 0) ? 1 : 0;
            $cont += DB::table("listadoPartidas")->where("id_pedimento", $idpedimento)->wherein("completo", [0,2])->count();
            $cont += DB::table("listadoCoves")->where("documento", "LIKE", "COVE%")->where("id_pedimento", $idpedimento)->wherein("completo", [0,2])->count();
            $cont += DB::table("listadoEdocuments")->where("id_pedimento", $idpedimento)->wherein("completo", [0,2])->count();

            return $cont;
        }

    }

    public static function archivos($path, $id, $user = '')
    {
        //-----------------------DOBLE CHECK SI EXISTE Y ESTA RELACIONADO CON EL ID ------------------//
        DB::table("archivos")->where("pedimento_id", $id)->where("procesando",1)->delete();
        $pedimento = DB::table("pedimentos")->where("id", $id)->first();

        $d = [];
        if($pedimento->aduana!=''){
            $d[] = substr($pedimento->aduana, 0, 2);
        }
        if($pedimento->patente!=''){
            $d[] = $pedimento->patente;
        }
        if($pedimento->pedimento!=''){
            $d[] = $pedimento->pedimento;
        }
        $foldercheck = implode("-",$d);


        if ($path!= disco($pedimento->licencia)."\\Expediente\\".$pedimento->licencia.'\\' . $foldercheck) {
            DB::table("pedimentos")->where("id", $id)->update(array(
                "actualizado"=>1,
                "procesando"=>0
            ));
            //GeneralRepository::publicar($path." != ".disco($pedimento->licencia)."\\Expediente\\".$pedimento->licencia.'\\' . $foldercheck);
            //echo $path." != ".disco($pedimento->licencia)."\\Expediente\\".$pedimento->licencia.'\\' . $foldercheck;
            return false;
        }
        if (!file_exists(disco($pedimento->licencia)."\\Expediente\\".$pedimento->licencia.'\\' . $foldercheck)) {
            //GeneralRepository::publicar("No existe ".disco($pedimento->licencia)."\\Expediente\\".$pedimento->licencia.'\\' . $foldercheck);
            //echo "No existe ".disco($pedimento->licencia)."\\Expediente\\".$pedimento->licencia.'\\' . $foldercheck;
            return false;
        }

        //GeneralRepository::publicar($path);

        DB::table("archivos")->where("pedimento_id", $id)->update(array(
            "procesando"=>1
        ));
        DB::table("pedimentos")->where("id", $id)->update(array(
            "procesando"=>1
        ));

        ini_set('max_execution_time', 300); //300 seconds = 5 minutes

        GeneralRepository::porcentajevu($id, $user);
        //-----------------------OBTENER ARCHIVOS DEL FOLDER---------------------------------------------------//
        $archivos = scandir($path);

        foreach ($archivos as $archivo) {
            if ($archivo != "." && $archivo != "..") {

                $hash = hash_file('md5', $path . '/' . $archivo);
                $filesize = filesize($path . '/' . $archivo);

                //-----------------------RECORRER MINIMOS PARA SABER SI EL ARCHIVO ES MINIMO-------------------//
                $min = "";
                $minimos = DB::table("minimos_user")
                    ->leftjoin("minimos", "minimos.id", "=", "minimos_user.minimo_id")
                    ->where("minimos_user.licencia_id", $pedimento->licencia)
                    ->where("minimos.operacion",$pedimento->operacion)
                    ->whereRaw("(minimos.clave ='".$pedimento->clave."' or minimos.clave='Todos')")
                    ->get();

                //dd($minimos);

                foreach ($minimos as $minimo) {
                    if ($minimo->archivo != "") {
                        if (strpos($archivo, $minimo->archivo) !== false) {
                            $min = $minimo->minimo_id;
                            break;
                        }
                    }
                }


                //-----------------------REGISTRAR EL ARCHIVO------------------//

                $file = DB::table("archivos")->where("archivos", $archivo)->where("pedimento_id", $id)->first();

                if ($file) {
                    try {

                        DB::table("archivos")->where("archivos", $archivo)->where("pedimento_id", $id)->update(array(
                            "minimo_id" => $min,
                            "updated_at" => DB::raw("GETDATE()"),
                            "hash" => $hash,
                            "filesize" => $filesize,
                            "procesando" => 0
                        ));
                    } catch (\Exception $e) {
                        continue;
                    }

                } else {

                    try {
                        DB::table("archivos")->insert(array(
                            "minimo_id" => $min,
                            "created_by" => $user . " [VU]",
                            "hash" => $hash,
                            "filesize" => $filesize,
                            "archivos" => $archivo,
                            "pedimento_id" => $id,
                            "created_at" => DB::raw("GETDATE()"),
                            "updated_at" => DB::raw("GETDATE()"),
                            "procesando" => 0
                        ));
                    } catch (\Exception $e) {
                        continue;
                    }
                }
            }
        }


        $filesize = getfileStorage($path);
        if($pedimento->filesize!=$filesize) {
            DB::table("pedimentos")->where("id", $id)->update(array(
                "filesize" => $filesize,
                "updated_at" => DB::raw("GETDATE()")
            ));
        }
        GeneralRepository::setFaltantes($id);
        DB::table("pedimentos")->where("id", $id)->update(array(
            "actualizado"=>1,
            "procesando"=>0
        ));
        return true;
    }

    public static function pedimentoRFC($pedimento, $rfc)
    {
        //Se registra con el permiso de quien lo subio

        $datos = [
            "pedimento_id" => $pedimento,
            "rfc" => $rfc
        ];

        $result = PedimentoUser::firstOrCreate($datos);

        //dd($result);
    }

    public static function getCredenciales()
    {
        $vucem = Vucem::select("id", DB::raw("(vucem.usuario+' | '+vucem.patente) as credencial"))->lists("credencial", "id");
        return $vucem;
    }

    /*
     * CALCULA EL PORCENTAJE COMPLETADO DEL EXPEDIENTE
     * POR PEDIMENTO O LICENCIA DEL USUARIO LOGUEADO
     * */
    public static function setFaltantes($id = 0)
    {

        if ($id != 0) {
            $pedimentos = DB::table("pedimentos")->where("id", $id)->get();
            $licencia = $pedimentos[0]->licencia;
        } else {
            $licencia = Auth::user()->licencia_id;
            $pedimentos = DB::table("pedimentos")->where("licencia", $licencia)->get();

        }

        foreach ($pedimentos as $pedimento) {

            $archivos = DB::table("archivos")->where("pedimento_id", $pedimento->id)
                ->where("minimo_id", "!=", "0")
                ->lists("minimo_id");

            //MINIMOS QUE TIENE QUE CUMPLIR
            $minimosCount = DB::table("minimos_user")
                ->leftjoin("minimos", "minimos.id", "=", "minimos_user.minimo_id")
                ->whereNotNull('minimos.id')
                ->where("minimos_user.licencia_id", $licencia)
                ->where("minimos.operacion",$pedimento->operacion)
                ->whereRaw("(minimos.clave ='".$pedimento->clave."' or minimos.clave='Todos')")
                ->count();
            //MINIMOS QUE NO TIENE
            $minimos = DB::table("minimos_user")
                ->leftjoin("minimos", "minimos.id", "=", "minimos_user.minimo_id")
                ->where("minimos_user.licencia_id", $licencia)
                ->where("minimos.operacion",$pedimento->operacion)
                ->whereRaw("(minimos.clave ='".$pedimento->clave."' or minimos.clave='Todos')")
                ->whereNotIn('minimos_user.minimo_id', $archivos)
                ->whereNotNull('minimos.id')
                ->select("minimos.*")->get();
            $porcentajes = ($minimosCount > 0) ? (count($minimos) * 100) / $minimosCount : 100;
            $porcentajes = 100 - $porcentajes;
            foreach ($minimos as $minimo) {
                Alerta::updateOrCreate(
                    [
                        "minimo_id" => $minimo->id,
                        "pedimento_id" => $pedimento->id
                    ],
                    [
                        "porcentaje" => $porcentajes
                    ]
                );
            }
            DB::table("pedimentos")->where("id", $pedimento->id)->update(array(
                "porcentaje" => $porcentajes
            ));
        }
        /**/
    }

    public static function mapaUsuario()
    {


        $agencias = DB::table("users")->where("role_id", 2)->where("parent", 0)->select("rfc", "nombre", "id")->get();

        $tree = '<ul>';
        foreach ($agencias as $agencia) {
            $tree .= '<li><span class="fa fa-building"></span> ' . $agencia->nombre . ' [' . $agencia->rfc . ']<ul>';
            $ejecutivos = DB::table("users")->where("role_id", 3)->where("parent", $agencia->id)->select("rfc", "nombre", "id")->get();
            foreach ($ejecutivos as $ejecutivo) {
                $tree .= '<li><span class="fa fa-suitcase"></span> ' . $ejecutivo->nombre . ' [' . $ejecutivo->rfc . ']<ul>';
                $agentes = DB::table("users")->where("role_id", 4)->where("parent", $ejecutivo->id)->select("rfc", "nombre", "id")->get();
                foreach ($agentes as $agente) {
                    $tree .= '<li><span class="fa fa-user-secret"></span> ' . $agente->nombre . ' [' . $agente->rfc . ']<ul>';
                    $importadores = DB::table("users")->where("role_id", 5)->where("parent", $agente->id)->select("rfc", "nombre", "id")->get();
                    foreach ($importadores as $importador) {
                        $tree .= '<li><span class="fa fa-user"></span> ' . $importador->nombre . ' [' . $importador->rfc . ']</li>';
                    }
                    $tree .= '</ul>';
                }
                $tree .= '</ul></li>';
            }
            $tree .= '</ul></li>';
        }
        $tree .= '</ul>';
        //var_dump($tree);
        return $tree;
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

    /*
     * Copia un folder al folder correspondiente en Expediente
     * */
    public static function procesarFolder($path,$licencia)
    {

        set_time_limit(0);
        // app/1/07-9999-600001/
        $path = str_replace("/","\\",$path);
        $partes = explode("\\", $path);
        $expediente = disco($licencia)."\\Expediente\\".$licencia."\\";
        $folderName = $partes[count($partes) - 1];

        if (is_dir($path)) {
            $archivos = scandir($path);
            foreach ($archivos as $archivo) {
                if (is_dir($path . '/' . $archivo) && $archivo != "." && $archivo != "..") {
                    $archivos = scandir($path . '/' . $archivo);
                    $path = $path . '/' . $archivo;
                    break;
                }
            }
            //Movemos el folder a su lugar y se registra
            if (!is_dir($expediente)) {
                mkdir($expediente);
            }
            $expedientePath = $expediente . $folderName;
            //dd($folderName);
            if (!is_dir($expedientePath)) {
                mkdir($expedientePath);
            }
            GeneralRepository::copy_directory($path, $expedientePath);
            return $folderName;
        }
    }

    public static function licencias()
    {
        $licencias = DB::table("licencias")->get();
        return $licencias;
    }

    public static function getlicencias()
    {
        $licencias = DB::table("licencias")->where("activo",1)->lists("empresa", "id");
        return $licencias;
    }
    public static function getlicenciasScan()
    {
        $licencias = DB::table("licencias")
            ->leftjoin('clientes','clientes.id','=','licencias.cliente_id')
            ->where("sistema",3)->lists("clientes.nombre", "licencias.id");
        return $licencias;
    }


    /**/
    public static function procesarFTPData($auto = "")
    {


        $uniq = date('Y-m-d H:i:s');

        while (GeneralRepository::getCont($auto)>0) {
            $query = Ftpdata::select("ftpdata.*","users.name","users.licencia_id","licencias.empresa")
                ->leftjoin("users", "users.id", "=", "ftpdata.creado")
                ->leftjoin("licencias", "licencias.id", "=", "users.licencia_id")
                ->where("ftpdata.procesado", 0)->where("ftpdata.procesando",0);

            if ($auto != 1) {
                $user = Auth::user()->licencia_id;
                $query->where("users.licencia_id", $user);
            }
            $zip = $query->first();

            Ftpdata::where("id", $zip->id)->update(array(
                "procesando" => 1
            ));

            //DB::beginTransaction();

            try {

                $rutaFTP = "C:\\ftpExpediente";
                $user = $zip->creado;
                $rfc = $zip->name;
                $licencia = $zip->licencia_id;
                $archivo = $zip->archivo;
                $file = $rutaFTP . "\\" . $user . "\\" . $archivo;

                $folderName = getFolderfromPath($archivo);

                /*Donde se descomprime el zip*/
                $appZip = storage_path() . '/app/' . $user . '/' . $folderName;
                if(!file_exists(storage_path() . '/app/' . $user)){
                    mkdir(storage_path() . '/app/' . $user);
                }
                if (file_exists($file)) {
                    $res = descomprimir($file, $appZip);
                    if (!$res) {
                        GeneralRepository::publicar("zip dañado");
                    }
                }
                else{
                    Ftpdata::where("id", $zip->id)->delete();
                    continue;
                }

                if (is_dir($appZip)) {
                    $folderName = procesarFolder($appZip, $licencia);
                }

                //REGISTRAR PEDIMENTO

                $datos = getInfofromFolder($folderName);

                $created = $rfc . " [App]";

                $pedimento = Pedimento::customUpdateOrCreate(
                    [
                        "aduana" => $datos["aduana"],
                        "patente" => $datos["patente"],
                        "pedimento" => $datos["pedimento"],
                    ],
                    [
                        "created_by" => $created,
                        "licencia" => $licencia

                    ],
                    [
                        "fechapago" => $datos["fechapago"]
                    ]
                );

                /**/
                $id = $pedimento->id;

                $expedientePath = disco($pedimento->licencia) . '\\Expediente\\' . $pedimento->licencia . "\\" . $folderName;
                GeneralRepository::archivos($expedientePath, $id, $created);

                Ftpdata::where("id", $zip->id)->update(array(
                    "procesado" => 1,
                    "idpedimento" => $pedimento->id,
                    "procesando" => 0
                ));

                //DB::commit();
                GeneralRepository::publicar(":ballot_box_with_check: ".$uniq . " | " . $zip->archivo . " | " . $zip->empresa . " | ".$zip->name);

            }catch (\Exception $e) {
                //DB::rollback();

                GeneralRepository::publicar(":negative_squared_cross_mark: ".$uniq . " | " . $zip->archivo . " | " . $zip->empresa." | ".$zip->name." | Error: ".$e->getMessage());
                Ftpdata::where("id", $zip->id)->delete();
            }



        }
    }
    public static function getCont($auto){
        $queryCount = Ftpdata::where("ftpdata.procesado", 0)->where("ftpdata.procesando",0);

        if ($auto != 1) {
            $user = Auth::user()->licencia_id;
            $queryCount->leftjoin("users", "users.id", "=", "ftpdata.creado")->where("users.licencia_id", $user);
        }
        $cont = $queryCount->count();
        return $cont;
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

    public static function fileStorage($licencia="")
    {

        $licencia = ($licencia=="")? Auth::user()->licencia_id:$licencia;
        $f = disco($licencia)."\\Expediente\\".$licencia;
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
        $operaciones = DB::connection("expediente")->table("pedimentos")->where("licencia",$licencia)->count();
        $vu = DB::connection("expediente")->table("pedimentos")->where("licencia",$licencia)->avg("vu");
        $vu = (int) $vu;

        DB::connection("expediente")->table("config1")->where("licencia_id",$licencia)->update(array(
            "usado"         => $size,
            "operaciones"   => $operaciones,
            "vu"            => $vu
        ));

        return $size;
    }

    public static function licencia()
    {
        $licencia = DB::connection("expediente")->table("config1")
            ->leftjoin("paquetes","paquetes.id","=","config1.paquete")
            ->select("config1.*","paquetes.capacidad")
            ->where("config1.licencia_id", Auth::user()->licencia_id)->first();
        return $licencia;
    }

    public static function getRegistros()
    {
        return $registros = array("Inicio de Pedimento", "Datos Generales", "Transporte", "Guías", "Contenedores", "Facturas",
            "Fechas", "Identificadores", "Cuentas Aduaneras y Cuentas Aduaneras de Garantía", "Contribuciones", "Observaciones",
            "Descargos", "Destinatario", "Partidas", "Mercancías", "Permisos", "Identificadores a nivel partida",
            "Cuentas Aduaneras de Garantía a nivel partida", "Tasas a nivel partida", "Conribuciones a nivel partida",
            "Observaciones a nivel partida", "Rectificación", "Diferencias de Contribuciones", "Selección Automatizada");
    }



    public static function clavesPedimento()
    {
        $licencia = Auth::user()->licencia_id;

        $claves = DB::table('pedimentos')->where('licencia', $licencia)->distinct('clave')->orderby('clave')->lists('clave');
        $claves[] = "Todos";

        return $claves;
    }

    public static function convertOperacion($key)
    {
        if ($key == 2) {
            return "Exportación";
        } else if ($key == 1)  {
            return "Importación";
        }
        else{
            return "";
        }
    }

    public static function checkMinimo($id)
    {
        $minimo = DB::connection("expediente")->table("minimos_user")->where("minimo_id", $id)->pluck("minimo_id");

        return $minimo;
    }

    public static function usuariosRegistrados($id)
    {
        $usuarios = DB::table("users")->where("admin",0)->where("licencia_id", $id)->count();

        return $usuarios;
    }

    public static function usuariosPermitidos($id)
    {
        $usuarios = DB::table("licencias")->where("id", $id)->pluck("usuarios");

        return $usuarios;
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

    public static function contribuyente($id)
    {
        $contribuyente = Contribuyente::find($id);
        return $contribuyente;
    }
    public static function getpais($clave){
        $pais = DB::table("paises")->where("CLAVEM3",$clave)->pluck("DESC_E");
        return $pais;
    }
    public static function getMoneda($clave){
        $pais = DB::table("monedas")->select(DB::raw("descpais + ' ' + moneda as moneda"))->where("clave",$clave)->pluck("moneda");
        return $pais;
    }
    public static function getUMT($clave){
        $pais = DB::table("umt")->where("clave",$clave)->pluck("descripcion");
        return $pais;
    }
    public static function AFPedimentos(){

        $a = activoFijo::leftjoin("pedimentos","pedimentos.id","=","activoFijo.idpedimento")
            ->select(
                DB::raw("(SUBSTRING(pedimentos.aduana,0,3)+'-'+pedimentos.patente+'-'+pedimentos.pedimento) as id"),
                DB::raw("(SUBSTRING(pedimentos.aduana,0,3)+'-'+pedimentos.patente+'-'+pedimentos.pedimento) as nombre")
            )
            ->where("pedimentos.licencia",Auth::user()->licencia_id)->distinct()->get();
        return $a;
    }
    public static function AFDescripcion(){

        $a = activoFijo::select(
            "activoFijo.descripcionGenerica as id",
            "activoFijo.descripcionGenerica as nombre"
        )
            ->where("licencia",Auth::user()->licencia_id)->distinct()->get();
        return $a;
    }
    public static function AFMarca(){

        $a = activoFijo::select(
            "activoFijo.marca as id",
            "activoFijo.marca as nombre"
        )
            ->where("licencia",Auth::user()->licencia_id)->distinct()->get();
        return $a;
    }
    public static function AFModelo(){

        $a = activoFijo::select(
            "activoFijo.modelo as id",
            "activoFijo.modelo as nombre"
        )
            ->where("licencia",Auth::user()->licencia_id)->distinct()->get();
        return $a;
    }
    public static function AFSerie(){

        $a = activoFijo::select(
            "activoFijo.numeroSerie as id",
            "activoFijo.numeroSerie as nombre"
        )
            ->where("licencia",Auth::user()->licencia_id)->distinct()->get();
        return $a;
    }
    public static function AFPlanta(){

        $a = activoFijo::select(
            "activoFijo.planta as id",
            "activoFijo.planta as nombre"
        )
            ->where("licencia",Auth::user()->licencia_id)->distinct()->get();
        return $a;
    }
    public static function AFSeccion(){

        $a = activoFijo::select(
            "activoFijo.seccion as id",
            "activoFijo.seccion as nombre"
        )
            ->where("licencia",Auth::user()->licencia_id)->distinct()->get();
        return $a;
    }
    public static function AFumt(){
        $a = activoFijo::leftjoin("pedimentos","pedimentos.id","=","activoFijo.idpedimento")
            ->leftjoin("umt","umt.clave","=","activoFijo.claveUnidadMedida")
            ->select(
                "umt.descripcion as id",
                "umt.descripcion as nombre"
            )
            ->where("pedimentos.licencia",Auth::user()->licencia_id)->distinct()->get();
        return $a;
    }
    public static function activosFaltantes(){
        $licencia = Auth::user()->licencia_id;
        $faltantes = activoFijo::where('licencia',$licencia)->where(function($query){
            $query->where('planta',null)->orWhere('planta','');
        })->where(function($query){
            $query->where('seccion',null)->orWhere('seccion','');
        })->count();
        return $faltantes;
    }
    public static function sPaquetes($id=0){
        $dominio = GeneralRepository::getCostoDominio();
        $registros = DB::table('paquetes')
            ->leftjoin("servidores","servidores.id","=","paquetes.servidor_id")
            ->select("paquetes.*","servidores.servidor", "servidores.costo as scosto","servidores.capacidad as scapacidad")
            ->get();

        $paquetes = [];
        foreach($registros as $registro){
            $preciopormb = $registro->scosto/$registro->scapacidad;
            $vendido = DB::table("licencias")
                ->leftjoin("paquetes","paquetes.id","=","licencias.paquete_id")
                ->where("licencias.id","!=",$id)->where("licencias.id","!=",1)
                ->where("paquetes.servidor_id",$registro->servidor_id)
                ->sum("licencias.capacidad");
            $libre = $registro->scapacidad-$vendido;
            $prorateo = $libre * ($registro->capacidad/$vendido);
            $precioprorateo = $prorateo*$preciopormb;
            $preciopaquete = $registro->capacidad*$preciopormb;
            $precio = $dominio+$preciopaquete+$precioprorateo;
            $paquetes[$registro->id] = $registro->nombre.' ('.$registro->servidor.') - $'.number_format($precio,2);
        }
        return $paquetes;
    }

    public static function getCostoDominio(){
        $dominioprecio = DB::table('dominios')->sum('precio');
        $clientes = DB::table("licencias")->where("id",">",1)->count();
        $dominio = ceil($dominioprecio/$clientes);
        return $dominio;
    }
    public static function Paquetes(){

        $registros = DB::table('paquetes')->get();
        return $registros;
    }
    public static function sServidores(){

        $registros = DB::table('servidores')->select("id",DB::raw("servidor+' ('+ip+')' as servidor"))->lists("servidor","id");
        return $registros;
    }
    public static function sClientes(){

        $registros = DB::table('clientes')->where("archivado","!=","1")->orderby("nombre")->lists("nombre","id");
        return $registros;
    }
    public static function sModulos(){

        $registros = DB::table('modulos')->orderby("nombre")->lists("nombre","id");
        return $registros;
    }
    public static function sClientes2(){

        $registros = DB::table('clientes')->orderby("nombre")->lists("nombre","id");
        $registros[0] = "Nuevo cliente";
        return $registros;
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
    public static function countHistorico(){
        $licencia = Auth::user()->licencia_id;
        $directory = disco($licencia)."\historico";
        if(!file_exists($directory)){
            mkdir($directory, 0777, true);
        }
        $archivos = File::allFiles($directory);
        return count($archivos);
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
    public static function ultimosAccesos(){
        $accesos = DB::table("user_log")
            ->select(
                "user_log.login_time",
                "users.nombre",
                DB::raw("(SELECT empresa FROM licencias WHERE licencias.id = users.licencia_id) as empresa")
            )->leftjoin("users","users.id","=","user_log.id_user")
            ->limit(20)->orderby("user_log.login_time", "desc")->get();
        return $accesos;
    }
    public static function getModulos(){
        $modulos = Sistema::where("sistema",1)->get();
        return $modulos;
    }
    public static function ModulosLicencia(){
        dd("test");
        $licencia = Auth::user()->licencia_id;
        $modulos = DB::connection("expediente")->table("modulos")->leftjoin("modulos_licencia", "modulos_licencia.id_modulo","=","modulos.id")
            ->where("modulos_licencia.id_licencia", $licencia)->get();
        return $modulos;
    }
    public static function checkModulo($modulo, $id){

        $modulo = DB::table("modulos_licencia")->where("id_modulo", $modulo)->where("id_licencia", $id)->pluck('id');
        return $modulo;
    }
    public static function checkSistema($modulo, $id){

        $modulo = DB::table("noticiasSistemas")->where("tipo_id", $modulo)->where("noticia_id", $id)->pluck('id');
        return $modulo;
    }
    public static function checkSubModulo($modulo, $id){

        $modulo = DB::table("submodulos_licencia")->where("id_submodulo", $modulo)->where("id_licencia", $id)->pluck('id');
        return $modulo;
    }
    public static function membretado(){
        $licencia = Auth::user()->licencia_id;
        $membretado = DB::table("licencias")->where("id", $licencia)->select("membretado1", "membretado2")->get();
        return $membretado;
    }
    public static function contribuciones($clave){
        $contribucion = DB::table("contribuciones")->where("clave",$clave)->pluck("abreviacion");
        return $contribucion;
    }
    public static function regimen($clave,$tipo){
        $contribucion = DB::table("regimenes")->where("clavepedimento",$clave)->where("tipo",$tipo)->pluck("regimenpedimento");
        return $contribucion;
    }
    public static function checkLicencia(){

        $url = "http://expediente.aduanasoft.com/activos/".Auth::user()->licencia_id;

        $ch=curl_init();
        $timeout=5;

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);

        // Get URL content
        $lines_string=curl_exec($ch);
        // close handle to release resources
        curl_close($ch);
        //output, you can also save it locally on the server
        return $lines_string;

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
    public static function publicar($text){
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
    public static function getYearPedimento($pedimento){
        $yearPrefixActual = substr(date('Y'),0,3);
        $yearActual = substr(date('Y'),-1);
        $y = (is_numeric($pedimento))? substr($pedimento,0,1):$yearActual;
        if($y>$yearActual){
            $yearPrefixActual = $yearPrefixActual-1;
        }
        return $yearPrefixActual.$y;
    }
    public static function folderName($file){
        $partes = explode(".", $file);
        $file = $partes[0];
        $partes = explode("-",$file);
        $d=[];
        if(isset($partes[count($partes)-3])){
            $d[] = substr(trim($partes[count($partes)-3]),0,2);
        }
        if(isset($partes[count($partes)-2])){
            $d[] = trim($partes[count($partes)-2]);
        }
        if(isset($partes[count($partes)-1])){
            $d[] = trim($partes[count($partes)-1]);
        }
        $folderName = implode("-",$d);
        return $folderName;
    }
    public static function getDataFolderName($folder){
        $partes = explode("-", $folder);
        $d=["","",""];
        if(isset($partes[count($partes)-3])){
            $d[0] = trim($partes[count($partes)-3])."0";
        }
        if(isset($partes[count($partes)-2])){
            $d[1] = trim($partes[count($partes)-2]);
        }
        if(isset($partes[count($partes)-1])){
            $d[2] = trim($partes[count($partes)-1]);
        }
        return $d;
    }
    public static function getFechasPedimentos(){
        $f = [];
        $meses = ["","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"];

        $fechas = DB::connection("expediente")->table("pedimentos")
            ->select(
                DB::raw("CONCAT(YEAR(fechapago),'-', RIGHT('0' + RTRIM(MONTH(fechapago)), 2)) AS fecha"),
                DB::Raw("COUNT(*) as qty")
            )
            ->where("licencia",Auth::user()->licencia_id)
            ->groupby(DB::raw("CONCAT(YEAR(fechapago),'-', RIGHT('0' + RTRIM(MONTH(fechapago)), 2))"))->orderby(DB::raw("CONCAT(YEAR(fechapago),'-', RIGHT('0' + RTRIM(MONTH(fechapago)), 2))"),"desc")
            ->get();

        $f[0] = "Fecha pago";
        $cont = 0;
        foreach ($fechas as $fecha){
            $partes = explode("-",$fecha->fecha);
            $index = intval($partes[1]);
            $f[$fecha->fecha]= $partes[0]." ".$meses[$index]." (".$fecha->qty.")";
            $cont+=$fecha->qty;
        }
        $f[99] = "Todos (".$cont.")";


        return $f;
    }
    public static function getClavesPedimentos(){
        $f = [];
        $meses = ["","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"];

        $fechas = DB::connection("expediente")->table("pedimentos")
            ->select(
                DB::raw("clave"),
                DB::Raw("COUNT(*) as qty")
            )
            ->where("licencia",Auth::user()->licencia_id)
            ->groupby("clave")
            ->get();

        $f[0] = "Clave";
        $cont = 0;
        foreach ($fechas as $fecha){
            $f[$fecha->clave]= $fecha->clave;
            $cont+=$fecha->qty;
        }



        return $f;
    }
    public static function getContribuyentesPedimentos(){
        $f = [];

        $fechas = DB::connection("expediente")->table("pedimentos")
            ->select(
                DB::raw("contribuyente"),
                DB::Raw("COUNT(*) as qty")
            )
            ->where("licencia",Auth::user()->licencia_id)
            ->groupby("contribuyente")
            ->get();

        $f[0] = "Contribuyente";
        $cont = 0;
        foreach ($fechas as $fecha){
            $f[$fecha->contribuyente]= $fecha->contribuyente;
            $cont+=$fecha->qty;
        }


        return $f;
    }
    public static function getCreadoPedimentos(){
        $f = [];

        $fechas = DB::connection("expediente")->table("pedimentos")
            ->select(
                DB::raw("created_by"),
                DB::Raw("COUNT(*) as qty")
            )
            ->where("licencia",Auth::user()->licencia_id)
            ->groupby("created_by")
            ->get();

        $f[0] = "Creado";
        $cont = 0;
        foreach ($fechas as $fecha){
            $f[$fecha->created_by]= $fecha->created_by;
            $cont+=$fecha->qty;
        }

        return $f;
    }
    public static function getDOF(){
        $content = file_get_contents("https://www.dof.gob.mx/");
        return $content;
    }
    public static function sistemas(){
        $sistemas = DB::table("sistemas")->get();
        return $sistemas;
    }
    public static function ssistemas(){
        $sistemas = DB::table("modulos")->lists("nombre","id");
        return $sistemas;
    }
    public static function sestatusSeguimiento(){
        $sistemas = DB::table("statusSeguimiento")->orderby("lugar","asc")->lists("nombre","id");
        return $sistemas;
    }
    public static function estatusSeguimiento(){
        $sistemas = DB::table("statusSeguimiento")->orderby("lugar","asc")->get();
        return $sistemas;
    }
    public static function noticias($cont=0){
        $query = Noticia::where("fecha","<=",DB::RAW("GETDATE()"))->orderby("fecha","desc");
        if($cont>0){
            $query->take($cont);
        }
        $sistemas = $query->get();
        return $sistemas;
    }
    public static function dominio($nombre){
        $sistemas = DB::table("dominios")->select("id","nombre","dominio","precio")->where("nombre", $nombre)->get();
        return $sistemas;
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

    public static function getCategorias()
    {
        $licencias = DB::connection("ryv_admin")->table("categorias")->orderby("categoria")->lists("categoria", "id");
        return $licencias;
    }
    //params[funcion], params[mensaje]
    public static function sendToFront($params=array()){
        $params2 = array(
            "do"        => "serverTalk",
            "licencia"  => Session::get("licencia_id"),
            "user"      => Session::get("user_id")
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
        $url = 'https://ryvconsultores.com.mx:3000';
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
        $registro = Config::where("parametro",$clave)->first();
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

    public static function setConnection($licencia){

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
    public static function sNoticiasCategorias(){
        return NoticiaCategoria::orderby("categoria")->lists("categoria","id");
    }
    public static function tipoDeCambio(){
        $tc = file_get_contents('https://dev.ryvconsultores.com.mx/tipoCambio/'.bin2hex(date('Y-m-d')));
        return $tc;
    }



}
