<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use ZipArchive;

class Actualizador extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'task:actualizar';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Actualizar sistema';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $ip_servidor    =   "74.208.183.125";
        $usuario        =   "rv_lolapop";
        $password       =   "rvadmin";
        $directorio     =   "/";

        echo date("Y-m-d H:i:s").": Conectando a servidor... ".PHP_EOL;

        $conexion_id    =   ftp_connect($ip_servidor); // creamos un ID de conexión al servidor
        $resultado      =   ftp_login($conexion_id,$usuario,$password); // iniciamos sesion con usuario y contraseña

        echo date("Y-m-d H:i:s").": Iniciando sesion... ".PHP_EOL;

        $archivos       =   [];
        ftp_pasv($conexion_id, true);

        if(!$contents = $this->listDetailed($conexion_id, $directorio)){
            echo date("Y-m-d H:i:s").": No se encontraron archivos ".PHP_EOL;
        }
        else{
            set_time_limit(0);
            foreach ($contents as $content){
                $file = $content["name"];
                if($file=="version.zip"){
                    $local = "C:\\xampp\\version.zip";
                    $remoto = $directorio."/".$content["name"];
                    $folder = "C:\\xampp\\htdocs";
                    //descarga el archivo del servidor en modo binario
                    if(ftp_get($conexion_id, $local, $remoto, FTP_BINARY)){
                        echo date("Y-m-d H:i:s").": Cargando la actualizacion... ".PHP_EOL;
                        if($this->descomprimir($local, $appZip)){
                            $fp = fopen(storage_path()."/db.sql", "r");
                            echo date("Y-m-d H:i:s").": Actualizando base de datos... ".PHP_EOL;
                            while (!feof($fp)){
                                $linea = fgets($fp);
                                DB::select($linea);
                            }
                            fclose($fp);
                            echo date("Y-m-d H:i:s").": Se ha actualizado exitosamente el sistema".PHP_EOL;
                        }
                        else{
                            echo date("Y-m-d H:i:s").": Ocurrio un error cargando la actualizacion ".PHP_EOL;
                        }
                    }
                    else{
                         echo date("Y-m-d H:i:s").": Ocurrio un error descargando la actualizacion ".PHP_EOL;
                    }
                }

            }
            
        }

        echo date("Y-m-d H:i:s").": Desconectando de servidor ".PHP_EOL;

        ftp_close($conexion_id);
    }
    public static function descomprimir($file,$destination,$del=true){
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
    function listDetailed($resource, $directory = '.') {
        if (is_array($children = @ftp_rawlist($resource, $directory))) {
            $items = array();

            foreach ($children as $child) {
                $partes = preg_split('/\s+/', $child, 9);
                /*list($perms, $links, $user, $group, $size, $d1, $d2, $d3, $name) =
                    preg_split('/\s+/', $child, 9);*/
                //$stamp = strtotime(implode(' ', array($d1, $d2, $d3)));
                $items[] = array('name' => $partes[3], 'timestamp' => $partes[2]);
            }

            return $items;
        }
    }
}
