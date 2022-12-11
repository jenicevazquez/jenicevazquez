<?php namespace App\Console\Commands;

use App\activoFijo;
use App\Helpers\General;
use App\Libraries\Massive\LoginXmlRequest;
use App\Libraries\Massive\RequestXmlRequest;
use App\Libraries\Massive\VerifyXmlRequest;
use App\Models\Archivo;
use App\Models\Contenedor;
use App\Models\Contribuyente;

use App\Licencia;
use App\ListadoCoves;
use App\ListadoEdocuments;
use App\ListadoFechas;
use App\ListadoPartidas;
use App\Models\Encabezado;
use App\Models\ListadoPedimentos;
use App\Models\Factura;
use App\Models\Fecha;
use App\Models\Guia;
use App\Models\Identificador;
use App\Models\Importador;
use App\Models\Pedimento;
use App\Models\PedimentoProveedor;
use App\Models\Prospecto;
use App\Models\ProspectoComentario;
use App\Models\Proveedor;
use App\Models\Rectificacion;
use App\Models\Registro501;
use App\Models\Transporte;
use App\Models\Vucem;
use App\Rojo;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use ZipArchive;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;
use ElephantIO\Client;
use ElephantIO\Engine\SocketIO\Version1X;
use Maatwebsite\Excel\Facades\Excel;

class Developer extends Command {
    public $expedientePath;
	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'task:developer';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Programacion rutinas especiales';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	public function fire()
	{
        echo "Iniciando...".PHP_EOL;
        $file = 'C:\\excel\\contactos.xlsx';
        $content = Excel::selectSheetsByIndex(0)->load($file, null, 'ISO-8859-1', function ($reader) {
            $reader->get()->toArray();
        })->get();
        //$result = $this->getLengths($content);
        //echo implode(", ",$result);
        //return;
        foreach ($content as $i=>$row) {
            echo $i." - ".$row["empresa"].PHP_EOL;
            $prospecto = Prospecto::updateOrCreate([
                "empresa"=>$row["empresa"]
            ],[
                "contacto"=>$row["contacto"]
                ,"correo"=>$row["correo"]
                ,"puesto"=>$row["puesto"]
                ,"telefono"=>$row["telefono"]
                ,"ext"=>$row["ext"]
                ,"ubicacion"=>$row["ubicacion"]
                ,"direccion"=>$row["direccion"]
                ,"perfil"=>$row["perfil"]
                ,"sistema"=>$row["sistema"]
            ]);
            ProspectoComentario::updateOrCreate([
                "prospectos_id"=>$prospecto->id
            ],[
                "comentario"=>$row["comentarios"]
            ]);
        }

	}
	function algo()
    {
        ini_set('memory_limit', -1);
        $pedimentos = Pedimento::where("vu","<",100)->get();
        foreach ($pedimentos as $pedimento){
            $listado = ListadoPedimentos::where("aduana",$pedimento->aduana)
                ->where("patente",$pedimento->patente)
                ->where("pedimento",$pedimento->pedimento)->update(array(
                    "id_pedimento"=>$pedimento->id,
                    "completo"=>0
                ));

        }

    }
    function algo2(){
        ini_set('memory_limit', -1);
        ListadoCoves::where("fecha","<",obtenerFechas()[1])->delete();

        echo "Listado Coves".PHP_EOL;
	    $datos = DB::table("listadoCoves")->select("id_pedimento")->where("fecha",null)->groupby("id_pedimento")->get();
	    foreach ($datos as $dato){
	        echo $dato->id_pedimento;
	        $pedimento = Pedimento::find($dato->id_pedimento);
	        if($pedimento){
                echo "...ok -";
	            ListadoCoves::where("id_pedimento",$dato->id_pedimento)->update(array(
	                "fecha"=>$pedimento->fechapago,
                    "licencia"=>$pedimento->licencia
                ));
            }
            else{
                echo "...not found -";
                DB::table("listadoCoves")->where("id_pedimento",$dato->id_pedimento)->delete();
            }
        }

    }
    function algo3(){
        ini_set('memory_limit', -1);
	    $pedimentos = Pedimento::wherein("licencia",[10,5,43])
            ->where("fechapago",">=",obtenerFechas()[1])
            ->get();
	    foreach ($pedimentos as $pedimento){
	        list($user,$medio) = explode(" ",$pedimento->created_by);
	        $registro = ListadoPedimentos::where("id_pedimento",$pedimento->id)->first();
	        if(!$registro){
	            echo "No se encontro ".$pedimento->patente.'-'.$pedimento->pedimento.PHP_EOL;
                ListadoPedimentos::create(array(
                    "aduana" => $pedimento->aduana,
                    "patente" => $pedimento->patente,
                    "pedimento" => $pedimento->pedimento,
                    "usuario" => $user,
                    "seccion" => $pedimento->seccion,
                    "fecha" => $pedimento->fechapago,
                    "licencia" => $pedimento->licencia
                ));
            }
        }
    }

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return [

		];
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return [

		];
	}

	function revisarRemesas(){
	    $remesas = DB::table("listadoPedimentos")->whereraw("id_pedimento is not null")->get();
	    foreach ($remesas as $remesa){
	        echo ".";
	        $pedimentos = DB::table("pedimentos")->where("id",$remesa->id_pedimento)->count();
	        if($pedimentos==0){
	            echo " - ".$remesa->id_pedimento.' - ';
                DB::table("listadoPedimentos")->where("id",$remesa->id)->delete();
            }
        }
    }
    function reprocesar(){
        ini_set('memory_limit', -1);
        $pedimentos = DB::table("pedimentos")
            ->wherein("licencia",[5])
            ->orderby("id","desc")->get();
        foreach ($pedimentos as $pedimento) {
            $id = $pedimento->id;
            $pedimento = Pedimento::find($id);
            $patente = $pedimento->patente;
            $licencia = $pedimento->licencia;
            $aduana = $pedimento->aduana;
            $folder = substr($pedimento->aduana, 0, 2) . "-" . $pedimento->patente . "-" . $pedimento->pedimento;
            $disco = disco($pedimento->licencia) . '\\Expediente\\' . $pedimento->licencia . '\\' . $folder . '\\';
            $file = $disco . 'VU_' . $pedimento->patente . '_' . $pedimento->pedimento . '.xml';
            if (file_exists($file)) {
                $result = file_get_contents($file);
                $result = str_replace('ns2:', '', $result);
                $result = str_replace('ns3:', '', $result);
                $result = str_replace('S:', '', $result);
                $xml = simplexml_load_string($result);
                $xml = $xml->Body->consultarPedimentoCompletoRespuesta;
                $tieneError = $xml->tieneError;
                $pedimento = $pedimento->pedimento;
                if ($tieneError != "true") {
                    echo $pedimento."...OK" . PHP_EOL;
                    if ($tieneError == "true") {
                        $this->error++;
                        //----------------------SI NO TIENE INFORMACION------------------------------------------------//
                        $result = $xml->error->mensaje;
                        echo $result." | ";
                        if ($result == 'No hay información para la búsqueda solicitada') {
                            ListadoPedimentos::where("patente", $patente)->where("pedimento", $pedimento)->update(array(
                                "completo" => 2
                            ));
                        } else {
                            echo("Pedimento Completo tiene error: " . $result);
                            return 3;
                        }
                        ListadoPedimentos::where("patente", $patente)->where("pedimento", $pedimento)->update(array(
                            "resCompleto" => $result
                        ));
                    } else {
                        if (isset($xml->pedimento->encabezado)) {
                            $lic = Licencia::where("id",$licencia)->first();
                            if($lic->tipo==1 && $xml->pedimento->importadorExportador->rfc!=$lic->rfc) {
                                ListadoPedimentos::where("patente", $patente)->where("pedimento", $pedimento)->update(array(
                                    "completo" => 1,
                                    "resCompleto" => "El RFC es diferente"
                                ));
                            }
                            //================FECHA DE PAGO==========================================//
                            $fecha = '';
                            if (isset($xml->pedimento->importadorExportador)) {
                                foreach ($xml->pedimento->importadorExportador->fechas as $fechita) {
                                    if ($fechita->tipo->clave == 2) {
                                        $fecha = $fechita->fecha;
                                        $partes = explode('-', $fecha);
                                        $fecha = $partes[0] . "-" . $partes[1] . "-" . $partes[2];
                                    }
                                }
                            }
                            //-----------REGISTRAR PEDIMENTOS CON LOS DATOS DEL XML-------------//
                            Pedimento::updateOrCreate(
                                [
                                    "aduana" => $aduana,
                                    "patente"   => $patente,
                                    "pedimento" => $pedimento
                                ],
                                [
                                    "fechapago" => $fecha
                                ]
                            );
                            echo $pedimento." - ".$fecha.PHP_EOL;
                        }
                    }
                } else {
                    echo "Tiene error " . $tieneError;
                }
            } else {
                echo "No se encontro " . $file;
            }
        }

    }
	function revisarPartidas(){
	    $partidas = DB::table("listadoPartidas")->where("completo",1)->orderby("id","desc")->get();
	    foreach ($partidas as $partida){
            echo $partida->id.' - ';
            $pedimento = DB::table("pedimentos")->where("id",$partida->id_pedimento)->first();
            if(!$pedimento){
                DB::table("listadoPartidas")->where("id_pedimento",$partida->id_pedimento)->delete();
                //dd("stop ".$partida->pedimento);
            }
            else{
                $folder = substr($pedimento->aduana,0,2)."-".$pedimento->patente."-".$pedimento->pedimento;
                $disco = disco($pedimento->licencia) . '\\Expediente\\' . $pedimento->licencia . '\\' . $folder . '\\';
                $file = $disco . 'VU_PARTIDA_' . $pedimento->pedimento . '-'.$partida->partida.'.xml';
                if(file_exists($file)) {
                    $result = file_get_contents($file);
                    $result = str_replace('ns8:', '', $result);
                    $result = str_replace('ns9:', '', $result);
                    $result = str_replace('S:', '', $result);
                    if($result!="") {
                        $xml = simplexml_load_string($result);
                        if($xml->Body->consultarPartidaRespuesta->tieneError=="true"){
                            DB::table("listadoPartidas")->where("id",$partida->id)->update(array(
                                "completo"=>0
                            ));
                            unlink($file);
                            echo $file."<br>";
                        }
                        else{
                            $xml = $xml->Body->consultarPartidaRespuesta->partida;
                            DB::table("listadoPartidas")->where("id",$partida->id)->update(array(
                                "fraccion"=>$xml->fraccionArancelaria
                            ));
                            echo " ok ";
                        }

                    }
                }
                else{
                    DB::table("listadoPartidas")->where("id",$partida->id)->update(array(
                        "completo"=>0
                    ));
                    echo $file."<br>";
                }
                $user = $pedimento->created_by;
                Archivo::archivos(disco($pedimento->licencia).'\\Expediente\\'.$pedimento->licencia.'\\' . $folder, $partida->id_pedimento, $user);
                //dd("stop");
            }

        }
    }
	function hacerzips(){
        $fechas = obtenerFechas();
        $partes = explode("-",$fechas[1]);
        $partes[2] = "01";
        $fecha = implode("-",$partes);
        $fechas = Pedimento::where("fechapago","<",$fecha)
            ->groupby(DB::raw("CAST(YEAR(fechapago) AS VARCHAR(4)) + '-' + CAST(MONTH(fechapago) AS VARCHAR(2)) + '-01'"))
            ->select(DB::raw("CAST(YEAR(fechapago) AS VARCHAR(4)) + '-' + CAST(MONTH(fechapago) AS VARCHAR(2)) + '-01' as fecha"))
            ->where("licencia",5)->lists("fecha");

        foreach ($fechas as $fecha){

            $pedimentos = Pedimento::whereRaw("(CAST(YEAR(fechapago) AS VARCHAR(4)) + '-' + CAST(MONTH(fechapago) AS VARCHAR(2)) + '-01' = '".$fecha."') and licencia=5")->get();

            // Initialize archive object
            $zip = new ZipArchive();
            $zip->open('C:\\xampp\\htdocs\\pexpediente\\storage\\historico\\5\\'.$fecha.'.zip', ZipArchive::CREATE | ZipArchive::OVERWRITE);

            // Initialize empty "delete list"
            $filesToDelete = array();
            $dirToDelete = array();

            foreach ($pedimentos as $pedimento){

                //OBTENER NOMBRE DEL FOLDER CORRESPONDIENTE//
                $adu = substr($pedimento->aduana, 0, 2);
                $folder = $adu . '-' . $pedimento->patente . '-' . $pedimento->pedimento;
                echo $folder.PHP_EOL;
                // Get real path for our folder
                $rootPath = realpath('C:\\xampp\\htdocs\\pexpediente\\storage\\Expediente\\'.$pedimento->licencia.'\\'.$folder);
                $rp = realpath('C:\\xampp\\htdocs\\pexpediente\\storage\\Expediente\\'.$pedimento->licencia);

                // Create recursive directory iterator*/
                $files = new RecursiveIteratorIterator(
                    new RecursiveDirectoryIterator($rootPath),
                    RecursiveIteratorIterator::LEAVES_ONLY
                );

                foreach ($files as $name => $file)
                {
                    // Skip directories (they would be added automatically)
                    if (!$file->isDir())
                    {
                        // Get real and relative path for current file
                        $filePath = $file->getRealPath();
                        $relativePath = substr($filePath, strlen($rp) + 1);

                        // Add current file to archive
                        $zip->addFile($filePath, $relativePath);
                        $filesToDelete[] = $filePath;
                    }
                }

                /**/
                Archivo::where("pedimento_id",$pedimento->id)->delete();
                Pedimento::where("id",$pedimento->id)->delete();
                $dirToDelete[] = $rootPath;
            }

            // Zip archive will be created only after closing object
            $zip->close();
            // Delete all files from "delete list"
            foreach ($filesToDelete as $file)
            {
                unlink($file);
            }
            foreach ($dirToDelete as $file)
            {
                rmdir($file);
            }
            die();
        }
    }
	function rojos(){
        $pedimentos = DB::table("pedimentos")->orderby("id","desc")->get();
        foreach ($pedimentos as $i=>$pedimento){
            $pathExpediente = "C:\\xampp\\htdocs\\pexpediente\\storage\\Expediente";
            $folder = substr($pedimento->aduana,0,2)."-".$pedimento->patente."-".$pedimento->pedimento;
            $file = $pathExpediente.'\\'.$folder.'\\VU_ESTADO_'.$pedimento->pedimento.'.xml';
            if(file_exists($file)) {
                $result = file_get_contents($file);
                $result = str_replace('ns2:', '', $result);
                $result = str_replace('ns3:', '', $result);
                $result = str_replace('S:', '', $result);
                $xml = simplexml_load_string($result);
                $xml = $xml->Body->consultarEstadoPedimentosRespuesta;
                if(isset($xml->pedimento->estadosPedimento)) {
                    foreach ($xml->pedimento->estadosPedimento as $estado) {
                        if ($estado->estado == 3) {
                            echo $pedimento->id.' - '.$pedimento->pedimento;
                            if ($estado->subEstado == 320)
                                echo ": Verde" . PHP_EOL;
                            else
                                echo ": Rojo" . PHP_EOL;

                            $factura = ($estado->secuencia != 0) ? $estado->factura : 0;
                            Rojo::updateOrCreate(array(
                                "idpedimento" => $pedimento->id,
                                "factura" => $factura,
                                "estado" => $estado->subEstado,
                                "licencia" => $pedimento->licencia
                            ));
                        }

                    }
                }
            }
        }
    }
	function setActivoFijo(){
        $pedimentos = DB::table("listadoCoves")
            ->select(
                "pedimentos.*",
                "listadoCoves.*",
                "pedimentos.id as idPedimento",
                "listadoCoves.id as idCove"
            )
            ->leftjoin("pedimentos","pedimentos.id","=","listadoCoves.id_pedimento")
            ->where("listadoCoves.documento", "LIKE", "COVE%")
            ->where("pedimentos.af","S")->get();
        foreach ($pedimentos as $i=>$pedimento){
            echo '1';
            $disco = DB::table("licencias")->where("id",$pedimento->licencia)->pluck("disco");
            if($disco=="C")
                $pathExpediente = "C:\\xampp\\htdocs\\pexpediente\\storage\\Expediente\\";
            else
                $pathExpediente = $disco.":\\Expediente\\";
            $pathExpediente .= $pedimento->licencia;
            $folder = substr($pedimento->aduana,0,2)."-".$pedimento->patente."-".$pedimento->pedimento;
            $file = $pathExpediente.'\\'.$folder.'\\'.$pedimento->documento.'.xml';
            if(file_exists($file)) {
                DB::table("listadoCoves")->where("id",$pedimento->idCove)->update(array("completo"=>1));
                $result = file_get_contents($file);
                $result = str_replace('ns2:', '', $result);
                $result = str_replace('ns3:', '', $result);
                $result = str_replace('S:', '', $result);
                $xml = simplexml_load_string($result);
                if(isset($xml->Body->ConsultarEdocumentResponse->response->resultadoBusqueda->cove)) {
                    $xml = $xml->Body->ConsultarEdocumentResponse->response->resultadoBusqueda->cove->facturas->factura->mercancias;
                    foreach ($xml->mercancia as $mercancia) {

                        if(isset($mercancia->descripcionesEspecificas->descripcionEspecifica->modelo)){
                            foreach ($mercancia->descripcionesEspecificas->descripcionEspecifica as $descripcion){
                                echo $descripcion->numeroSerie." - ";
                                activoFijo::updateOrCreate(
                                    [
                                        "idpedimento" => $pedimento->idPedimento,
                                        "marca" => $descripcion->marca,
                                        "modelo" => $descripcion->modelo,
                                        "numeroSerie" => $descripcion->numeroSerie

                                    ],
                                    [
                                        "descripcionGenerica" => $mercancia->descripcionGenerica,
                                        "claveUnidadMedida" => $mercancia->claveUnidadMedida,
                                        "tipoMoneda" => $mercancia->tipoMoneda,
                                        "cantidad" => 1,
                                        "licencia" => $pedimento->licencia,
                                        "valorUnitario" => $mercancia->valorUnitario,
                                        "valorTotal" => $mercancia->valorTotal,
                                        "valorDolares" => $mercancia->valorDolares
                                    ]
                                );
                            }
                        }
                        else{
                            echo $mercancia->descripcionGenerica." - ";
                            activoFijo::updateOrCreate(
                                [
                                    "idpedimento" => $pedimento->idPedimento,
                                    "descripcionGenerica" => $mercancia->descripcionGenerica,

                                ],
                                [

                                    "claveUnidadMedida" => $mercancia->claveUnidadMedida,
                                    "tipoMoneda" => $mercancia->tipoMoneda,
                                    "cantidad" => $mercancia->cantidad,
                                    "licencia" => $pedimento->licencia,
                                    "valorUnitario" => $mercancia->valorUnitario,
                                    "valorTotal" => $mercancia->valorTotal,
                                    "valorDolares" => $mercancia->valorDolares
                                ]
                            );
                        }
                    }
                }
            }
            else{
                echo '!'.$file;
                DB::table("listadoCoves")->where("id",$pedimento->idCove)->update(array("completo"=>0));
                //die();
            }
        }
    }
	function getSizePedimentos(){
        $pedimentos = DB::table("pedimentos")->orderby("id","desc")->get();
        foreach ($pedimentos as $i=>$pedimento){
            $size = DB::table("archivos")->where("pedimento_id",$pedimento->id)->sum("filesize");
            echo $size." ";
            $p = Pedimento::find($pedimento->id);
            $p->fill(array("filesize"=>$size));
            $p->save();
        }
    }
	function archivos2(){
        //$pathExpediente = "C:\\xampp\\htdocs\\pexpediente\\storage\\Expediente";
        $pedimentos = DB::table("pedimentos")->orderby("id","desc")->get();
        foreach ($pedimentos as $i=>$pedimento){
            $folder = substr($pedimento->aduana,0,2)."-".$pedimento->patente."-".$pedimento->pedimento;
            $p = round(($i/count($pedimentos))*100,0);

            $pedimento_id = $pedimento->id;
            $user = $pedimento->created_by;
            if(file_exists(disco($pedimento->licencia).'\\Expediente\\'.$pedimento->licencia.'\\' . $folder)) {
                echo PHP_EOL.$p."% | ".$folder." | ";
                General::archivos(disco($pedimento->licencia).'\\Expediente\\'.$pedimento->licencia.'\\' . $folder, $pedimento_id, $user);
            }

        }
    }
    function borrarArchivosNoExisten(){
        $pathExpediente = "C:\\xampp\\htdocs\\pexpediente\\storage\\Expediente";
        $pedimentos = DB::table("pedimentos")->orderby("id","desc")->get();
        foreach ($pedimentos as $i=>$pedimento){
            $folder = substr($pedimento->aduana,0,2)."-".$pedimento->patente."-".$pedimento->pedimento;
            echo ".";
            $path = $pathExpediente."\\".$folder;
            $archivos = DB::table("archivos")->where("pedimento_id",$pedimento->id)->get();
            foreach ($archivos as $x=>$archivo) {
                if(!file_exists($path.'\\'.$archivo->archivos)){
                    $p = round(($i/count($pedimentos))*100,0);
                    echo $p." - ".$folder.PHP_EOL;
                    echo $x."/".count($archivos)." NO EXISTE ".$path.'\\'.$archivo->archivos.PHP_EOL;
                    DB::table("archivos")->where("id",$archivo->id)->delete();
                }
            }

        }
    }
	function edocuments(){
        $pathExpediente = "C:\\xampp\\htdocs\\pexpediente\\storage\\Expediente";
        $edocuments = DB::table("listadoEdocuments")->get();
        foreach ($edocuments as $i=>$edocument){
            $folder = substr($edocument->aduana,0,2)."-".$edocument->patente."-".$edocument->pedimento;
            $file = $pathExpediente."\\".$folder."\\".$edocument->documento.".xml";
            echo ".";
            if (file_exists($file)) {
                //echo "EXISTE XML  ".$file.PHP_EOL;
                $edocs = DB::table("listadoEdocuments")->where("patente",$edocument->patente)->where("documento",$edocument->documento)
                    ->where("completo","!=",1)->get();
                if(count($edocs)>0) {
                    $p = round($i/count($edocuments),0)."% | ";
                    echo $p." DOCUMENTO: " . $edocument->documento . PHP_EOL;
                    echo "HAY " . count($edocs) . " pedimentos con el mismo edocument" . PHP_EOL;
                    foreach ($edocs as $edoc) {
                        $folder2 = substr($edoc->aduana,0,2)."-".$edoc->patente."-".$edoc->pedimento;
                        $pedimento_id = $edoc->id_pedimento;
                        $user = $edoc->usuario . ' [VU]';
                        $file2 = $pathExpediente . "\\" . $folder2 . "\\" . $edoc->documento . ".xml";
                        if($file==$file2){
                            echo "SE CAMBIO EL STATUS A COMPLETADO " . PHP_EOL;
                            DB::table("listadoEdocuments")->where("id", $edoc->id)->update(array("completo" => 1));
                            General::archivos('C:\xampp\htdocs\pexpediente\storage\Expediente\\' . $folder2, $pedimento_id, $user);
                        }
                        else if (copy($file, $file2)) {
                            $file = $pathExpediente . "\\" . $folder . "\\" . $edocument->documento . ".pdf";
                            if (file_exists($file)) {
                                //echo "EXISTE PDF  " . $file . PHP_EOL;
                                DB::table("listadoEdocuments")->where("id", $edocument->id)->update(array("completo" => 1));
                                $file2 = $pathExpediente . "\\" . $folder2 . "\\" . $edoc->documento . ".pdf";

                                if (copy($file, $file2)) {
                                    echo "-> SE COPIO ".PHP_EOL.$file.PHP_EOL. $file2 . PHP_EOL;

                                    General::archivos('C:\xampp\htdocs\pexpediente\storage\Expediente\\' . $folder2, $pedimento_id, $user);
                                    DB::table("listadoEdocuments")->where("id", $edoc->id)->update(array("completo" => 1));

                                } else {
                                    echo "- NO SE COPIO PDF " . $file . " A " . $file2 . PHP_EOL;

                                }
                            } else {
                                if($edocument->completo!=0) {
                                    echo "NO SE ENCONTRO PDF " . $file . PHP_EOL;
                                    DB::table("listadoEdocuments")->where("id", $edocument->id)->update(array("completo" => 0));

                                }
                            }

                        } else {
                            echo "NO SE COPIO XML " . $file . " A " . $file2 . PHP_EOL;
                        }
                    }
                }
            }
            else{
                if($edocument->completo!=0) {
                    echo "NO SE ENCONTRO XML " . $file . PHP_EOL;
                    DB::table("listadoEdocuments")->where("id", $edocument->id)->update(array("completo" => 0));

                }
            }

        }
    }
	function getXML($file){
        $result = file_get_contents($file);
        $result = str_replace('ns2:', '', $result);
        $result = str_replace('ns3:', '', $result);
        $result = str_replace('S:', '', $result);
        $xml = simplexml_load_string($result);
        $xml = $xml->Body->consultarPedimentoCompletoRespuesta;
        return $xml;
    }
    function contingencia(){
        $pedimentos = DB::table("pedimentos")->get();
        $pathExpediente = "C:\\xampp\\htdocs\\pexpediente\\storage\\Expediente";
        foreach ($pedimentos as $pedimento){
            $file = $pathExpediente."\\".substr($pedimento->aduana,0,2)."-".$pedimento->patente."-".$pedimento->pedimento."\\VU_".$pedimento->patente."_".$pedimento->pedimento.".xml";
            if (file_exists($file)) {
                //echo "SI se encontro: ".$pedimento->patente."-".$pedimento->pedimento.PHP_EOL;
                $xml = $this->getXML($file);
                /*if(isset($xml->pedimento->identificadores)) {
                    foreach ($xml->pedimento->identificadores->identificadores as $iden) {
                        if ($iden->claveIdentificador->clave == "OC") {
                            echo("------->Contingencia " . $pedimento->patente . "-" . $pedimento->pedimento . PHP_EOL);
                            DB::table("pedimentos")->where("id", $pedimento->id)->update(array(
                                "contingencia" => 1
                            ));
                        }
                    }
                }*/
                if(isset($xml->pedimento->encabezado->aduanaEntradaSalida->clave)) {

                    $clave = (string)$xml->pedimento->encabezado->aduanaEntradaSalida->clave;
                    $clave = (strlen($clave)==2)? "0".$clave:$clave;
                    echo "Clave: ".$clave.PHP_EOL;
                    DB::table("pedimentos")->where("id",$pedimento->id)->update(array(
                        "seccion"=>$clave
                    ));
                }
            }
            else{
                echo "No se encontro: ".$file.PHP_EOL;
                DB::table("listadoPedimentos")->where("id_pedimento", $pedimento->id)->update(array(
                    "completo" => 0
                ));
            }
        }
    }
    function rectificacion(){
        $pedimentos = DB::table("pedimentos")->get();
        $pathExpediente = "C:\\xampp\\htdocs\\pexpediente\\storage\\Expediente";
        foreach ($pedimentos as $pedimento){
            $file = $pathExpediente."\\".substr($pedimento->aduana,0,2)."-".$pedimento->patente."-".$pedimento->pedimento."\\VU_".$pedimento->patente."_".$pedimento->pedimento.".xml";
            if (file_exists($file)) {
                //echo "SI se encontro: ".$pedimento->patente."-".$pedimento->pedimento.PHP_EOL;
                $xml = $this->getXML($file);
                if(isset($xml->pedimento->rectificacion)) {
                    $fechapago = $xml->pedimento->rectificacion->fechaPago;
                    echo("------->Rectificacion " . $pedimento->patente . "-" . $pedimento->pedimento.": ".$fechapago . PHP_EOL);
                    DB::table("pedimentos")->where("id", $pedimento->id)->update(array(
                        "fechapago" => $fechapago,
                        "clave"     => "R1"
                    ));
                }
            }
            /*else{
                echo "No se encontro: ".$file.PHP_EOL;
                DB::table("listadoPedimentos")->where("id_pedimento", $pedimento->id)->update(array(
                    "completo" => 0
                ));
            }*/
        }
    }
    function contribuyentes(){
        $pedimentos = DB::table("pedimentos")->orderby("created_at","desc")->where("licencia",45)->get();
        $pathExpediente = "D:\\Expediente\\45";
        foreach ($pedimentos as $pedimento){
            $file = $pathExpediente."\\".substr($pedimento->aduana,0,2)."-".$pedimento->patente."-".$pedimento->pedimento."\\VU_".$pedimento->patente."_".$pedimento->pedimento.".xml";
            if (file_exists($file)) {
                echo "SI se encontro: ".$pedimento->patente."-".$pedimento->pedimento.PHP_EOL;
                $xml = $this->getXML($file);
                if(isset($xml->pedimento->importadorExportador)) {
                    $usuario = (isset($xml->pedimento->importadorExportador->rfc))? trim($xml->pedimento->importadorExportador->rfc):trim($xml->pedimento->importadorExportador->curp);
                    $pass = $pass = substr(MD5(rand(5, 100)), 0, 8);
                    $razon = trim($xml->pedimento->importadorExportador->razonSocial);
                    $calle = trim($xml->pedimento->importadorExportador->domicilio->calle);
                    $num = trim($xml->pedimento->importadorExportador->domicilio->numeroExterior);
                    $municipio = trim($xml->pedimento->importadorExportador->domicilio->ciudadMunicipio);
                    $cp = trim($xml->pedimento->importadorExportador->domicilio->codigoPostal);
                    $pais = trim($xml->pedimento->importadorExportador->pais->clave);
                    $licencia = $pedimento->licencia;
                    echo $usuario.PHP_EOL;
                    $cont = Contribuyente::where("usuario",$usuario)->count();
                    if($cont==0){

                        Contribuyente::create(array(
                            "usuario" => $usuario,
                            "pass" => base64_encode($pass),
                            "razonsocial" => $razon,
                            "calle" => $calle,
                            "exterior" => $num,
                            "cp" => $cp,
                            "municipio" => $municipio,
                            "pais" => $pais,
                            "licencia" => $licencia
                        ));
                    }
                    else{
                        Contribuyente::where("usuario",$usuario)->update(array(
                            "razonsocial" => $razon,
                            "calle" => $calle,
                            "exterior" => $num,
                            "cp" => $cp,
                            "municipio" => $municipio,
                            "pais" => $pais,
                            "licencia" => $licencia
                        ));
                    }

                }
            }
            else{
                echo "No se encontro: ".$file.PHP_EOL;
                DB::table("listadoPedimentos")->where("id_pedimento", $pedimento->id)->update(array(
                    "completo" => 0
                ));
            }
        }
    }


}
