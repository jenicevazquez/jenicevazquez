<?php


namespace App\Http\Controllers;
use App\Http\Requests;
use App\Libraries\Repositories\GeneralRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Imagick;
use Response;
use ZipArchive;

class DigitalizadorController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(){
        return view('digitalizador.index');
    }

    public function subirArchivoDigitalizador(Request $request){
        ini_set("memory_limit", "-1");
        set_time_limit(0);
        $input = $request->all();
        $token = $input["_token"];
        $input["calidad"] = $input["calidad"] ?? 120;
        $input["tipoPartes"] = $input["tipoPartes"] ?? "tamanio";
        $input["tamanio"] = $input["tamanio"] ?? 3;
        $input["partes"] = $input["partes"] ?? 3;
        $p = 0;
        try {
            $user = Auth::user()->id;
            $path = storage_path() . "\\exports\\" . $user;
            checkandcreatePath($path);

            if ($request->hasFile('archivo')) {
                set_time_limit(0);
                $file = $request->file('archivo');
                $extension = $file->getClientOriginalExtension();
                $nombre = $file->getClientOriginalName();
                if ($extension != "pdf") {
                    $res = ["error", "El archivo tiene que ser pdf"];
                    return $res;
                }
                $archivos = scandir($path);
                $removeDirs = array(".", "..");
                $archivos = array_diff($archivos, $removeDirs);
                foreach ($archivos as $archivo) {
                    if (file_exists($path."\\".$archivo)) {
                        //unlink($path."\\".$archivo);
                    }
                }
                $file->move($path, $nombre);
                ob_end_clean();
                $fileName = $path . "\\" . str_replace("." . $extension, "", $nombre);
                $imagick = new Imagick();
                $this->sendtofront($token, "Leyendo archivo...");
                $this->checkCancel($token,$fileName . '.pdf');
                $this->sendtofront($token, "Optimizando documento...");
                $res = $this->convertPDF($fileName,120);
                $fileNameConverted = ($res[0]=="success")? $res[1]:$fileName;
                $this->sendtofront($token, "Procesando...");
                $imagick->readImage($fileNameConverted . '.pdf');
                $noOfPages = $imagick->getNumberImages();
                $this->sendtofront($token, "El archivo tiene " . $noOfPages . " paginas");
                $this->checkCancel($token,$fileName . '.pdf');
                $convertedImageNames = [];
                $convertedPdfNames = [];
                $paquetes = [];
                $bytes = 0;
                $partes = 0;
                $x = 0;
                $total = 0;
                $step = $noOfPages>0? 50/$noOfPages:50;
                if($input["tipoPartes"]=="tamanio") {
                    $bytes = $input["tamanio"] * 1000 * 1000;
                }
                else{
                    $partes = ceil($noOfPages/$input["partes"]);
                }
                $cont = 0;
                for ($i = 0; $i < $noOfPages; $i++) {
                    $p += $step;
                    $this->sendtofront($token, ($i+1) . "/" . $noOfPages . " Procesando pagina " . ($i+1) . "...",$p);
                    $image = new Imagick();
                    $image->setBackgroundColor('white');
                    $image->setResolution(300,300);
                    $image->readImage($fileNameConverted . '.pdf' . '[' . $i . ']');
                    $image->setImageFormat("jpeg");
                    $image->resizeImage(2550,0,imagick::FILTER_LANCZOS, 1);
                    $image->setImageResolution(300,300);
                    $image->setImageAlphaChannel(Imagick::ALPHACHANNEL_REMOVE);
                    $image->setImageType(Imagick::IMGTYPE_GRAYSCALE);
                    $image->setImageDepth(8);
                    $image->mergeImageLayers(Imagick::LAYERMETHOD_FLATTEN);
                    $image->setImageCompression(Imagick::COMPRESSION_JPEG);
                    $image->setImageCompressionQuality(20);
                    $image->stripimage();
                    $image->setImageInterlaceScheme(imagick::INTERLACE_PLANE);
                    $image->setSamplingFactors(array('2x2', '1x1', '1x1'));
                    $colors = $image->getImageColors();

                    if ($colors > 1) {
                        $image->writeImage($fileName . '-' . $i . '.jpg');
                        $convertedImageNames[$i] = $fileName . '-' . $i . '.jpg';
                        $tamanio = filesize($fileName . '-' . $i . '.jpg');

                        if($input["tipoPartes"]=="tamanio") {
                            $this->sendtofront($token, ($i+1) . "/" . $noOfPages . " Pagina " . ($i+1) . " ".$total." ".$tamanio,$p);
                            if ($total + $tamanio < $bytes) {
                                $paquetes[$x][] = $fileName . '-' . $i . '.jpg';
                                $total += $tamanio;
                            } else {
                                $x++;
                                $paquetes[$x][] = $fileName . '-' . $i . '.jpg';
                                $total = $tamanio;
                            }
                        }
                        else{
                            if($cont<$partes){
                                $paquetes[$x][] = $fileName . '-' . $i . '.jpg';
                                $cont++;
                            }
                            else{
                                $x++;
                                $paquetes[$x][] = $fileName . '-' . $i . '.jpg';
                                $cont=0;
                            }
                        }
                    }else{
                        $this->sendtofront($token, ($i+1) . "/" . $noOfPages . " Pagina " . ($i+1) . " en blanco, no se agregará.",$p);
                    }
                    $image->destroy();

                }
                $totArchivos = count($paquetes);
                $this->sendtofront($token, "Se crearán " . $totArchivos . " archivos pdf");
                $this->checkCancel($token,$fileName . '.pdf');
                $step = $totArchivos>0? 50/$totArchivos:50;
                foreach ($paquetes as $i => $paquete) {
                    $p += $step;
                    $nombreArchivo = $fileName . '_vucem-' . $i . '.pdf';
                    $this->sendtofront($token, ($i+1) . "/" . $totArchivos . " Creando archivo " . basename($nombreArchivo) . "...",$p);
                    $pdf = new Imagick($paquete);
                    $pdf->setImageFormat('pdf');
                    $pdf->writeImages($nombreArchivo, true);
                    $convertedPdfNames[$i] = $nombreArchivo;
                    $pdf->destroy();
                }
                $imagick->destroy();
                $this->sendtofront($token, "Creando zip...");
                $this->checkCancel($token,$fileName . '.pdf');
                foreach ($convertedImageNames as $imagen) {
                    if (file_exists($imagen)) {
                        unlink($imagen);
                    }
                }
                $this->sendtofront($token, "Listo. Tambien puede descargar sus archivos a la derecha ->",100,'info');
                $this->checkCancel($token,$fileName . '.pdf');
                $this->makeZip($convertedPdfNames,$fileName.".zip");
                GeneralRepository::slack("Se digitalizó un archivo -" . Auth::user()->name);
                return ["success",basename($fileName.".zip")];

            } else {
                return ["error", "No se indicó archivo pdf"];
            }

        }catch (\Exception $e) {
            $this->sendtofront($token, "ERROR [".$e->getLine()."] : " . $e->getMessage(),null,"danger");
            return ["error", "ERROR [".$e->getLine()."] : " . $e->getMessage()];
        }
    }
    public function convertPDF($fileName,$dpi){
        try{
            $imagick = new Imagick();
            $imagick->readImage($fileName . '.pdf');
            $noOfPages = $imagick->getNumberImages();
            $imagick->destroy();
            $ancho = $dpi*8.5;
            $paquete=[];
            for ($i = 0; $i < $noOfPages; $i++) {
                $image = new Imagick();
                $image->setBackgroundColor('white');
                $image->setResolution(300, 300);
                $image->readImage($fileName . '.pdf' . '[' . $i . ']');
                $image->setImageFormat("jpeg");
                $image->resizeImage($ancho, 0, imagick::FILTER_LANCZOS, 1);
                $image->setImageResolution($dpi, $dpi);
                $image->setImageAlphaChannel(Imagick::ALPHACHANNEL_REMOVE);
                $image->setImageType(Imagick::IMGTYPE_GRAYSCALE);
                $image->setImageDepth(8);
                $image->mergeImageLayers(Imagick::LAYERMETHOD_FLATTEN);
                $image->setImageCompression(Imagick::COMPRESSION_JPEG);
                $image->setImageCompressionQuality(20);
                $image->stripimage();
                $image->setImageInterlaceScheme(imagick::INTERLACE_PLANE);
                $image->setSamplingFactors(array('2x2', '1x1', '1x1'));
                $colors = $image->getImageColors();

                if ($colors > 1) {
                    $image->writeImage($fileName . '-' . $i . '.jpg');
                    $paquete[] = $fileName . '-' . $i . '.jpg';
                }
                $image->destroy();
            }
            $nombreArchivo = $fileName . '_'.$dpi;
            $pdf = new Imagick($paquete);
            $pdf->setImageFormat('pdf');
            $pdf->writeImages($nombreArchivo.'.pdf', true);
            $pdf->destroy();
            foreach ($paquete as $imagen) {
                if (file_exists($imagen)) {
                    unlink($imagen);
                }
            }
            return ["success",$nombreArchivo];
        }catch (\Exception $e) {
            return ["error", "ERROR [".$e->getLine()."]: " . $e->getMessage()];
        }
    }

    public function listArchivosDigitalizados(Request $request){
        $user = Auth::user()->id;
        $path = storage_path()."\\exports\\".$user."\\";
        //$archivos = scandir($path);
        $archivos = glob($path . "*.zip");
        $removeDirs = array(".", "..");
        foreach ($archivos as $i=>$archivo){
            $archivos[$i] = str_replace($path,"",$archivo);
        }
        $archivos = array_diff($archivos, $removeDirs);
        return $archivos;
    }
    public function verArchivoDigitalizado($filename){
        $user = Auth::user()->id;
        $path = storage_path()."\\exports\\".$user;
        //$filename = base64_decode($filename);
        $name = $filename;
        $path = $path."\\".$filename;
        $mime = mime_content_type($path);

        return Response::make(file_get_contents($path),200,[
            'Content-Type' => $mime,
            'Content-Disposition' => 'attachment; filename="'.$name.'"'
        ]);
    }
    public function cancelar(Request $request){
        $user = Auth::user()->id;
        $path = storage_path() . "\\exports\\" . $user;
        $archivos = scandir($path);
        $removeDirs = array(".", "..");
        $archivos = array_diff($archivos, $removeDirs);
        foreach ($archivos as $archivo) {
            if (file_exists($path."\\".$archivo)) {
                unlink($path."\\".$archivo);
            }
        }

    }
    function makeZip($filenames,$namezip)
    {
        if (file_exists($namezip)) {
            unlink($namezip);
        }
        if (count($filenames) > 0) {
            $zip = new ZipArchive();
            if ($zip->open($namezip, ZIPARCHIVE::CREATE) === true) {
                foreach ($filenames as $i => $file) {
                    if (file_exists($file)) {
                        $zip->addFile($file, basename($file));
                    }
                }
                $zip->close();
                return ["success", $namezip];

            } else {
                return ["error", 'Error creando zip'];
            }
        }
        return ["error", "No hay archivos para descargar"];
    }
    function sendtofront($token,$mensaje,$porcentaje=null,$clase=null){

        $params = array(
            "funcion" => "digitalizador",
            "mensaje" => date('d-m-y h:i:s') . ": " .$mensaje,
            "porcentaje" => $porcentaje,
            "token" => $token,
            "clase" => $clase
        );
        GeneralRepository::sendToFront($params);

    }
    function checkCancel($token,$filename){
        if(!file_exists($filename)){
            $this->sendtofront($token,"Se cancelo el proceso.");
            die();
        }
    }

}