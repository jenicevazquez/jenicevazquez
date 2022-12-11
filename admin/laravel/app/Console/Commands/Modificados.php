<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use ZipArchive;

class Modificados extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'task:getModificados';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Obtener archivos modificados';

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
        $zipFile = "C:\\FTP\\lolapop\\version.zip";
        $rootPath = "C:\\xampp\\htdocs\\lolapop\\";
        clearstatcache();
        echo date("Y-m-d H:i:s").": INICIO".PHP_EOL;
        if(!file_exists($zipFile)) {

            /*hacer zip*/
            echo date("Y-m-d H:i:s").": FULL ZIP".PHP_EOL;
            $files = new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator($rootPath),
                \RecursiveIteratorIterator::LEAVES_ONLY
            );
            $this->hacerZip($zipFile,$files,$rootPath);
            /**/
        }
        else{

            $version = date("Y-m-d H:i:s", filemtime($zipFile));
            echo date("Y-m-d H:i:s").": Last version ".$version." ".PHP_EOL;
            $archivos = [];

            $archivos = $this->listar_directorios_ruta($rootPath,$version,$archivos);
            echo date("Y-m-d H:i:s").": ".count($archivos)." archivos modificados ".PHP_EOL;
            if(count($archivos)>0){
                $this->hacerZip($zipFile,$archivos,$rootPath);
            }
        }
        echo date("Y-m-d H:i:s").": FIN ".PHP_EOL;
    }
    function hacerZip($pathZip,$files,$rootPath){
        $zip = new ZipArchive();
        $zip->open($pathZip, ZipArchive::CREATE | ZipArchive::OVERWRITE);
        foreach ($files as $name => $file) {
            // Skip directories (they would be added automatically)
            if (!is_dir($file)) {
                // Get real and relative path for current file
                $filePath = $file;
                $relativePath = substr($filePath, strlen($rootPath));

                // Add current file to archive
                $zip->addFile($filePath, $relativePath);
            }
        }
        $zip->close();
    }
    function listar_directorios_ruta($ruta,$version,$archivos){

        if (is_dir($ruta)) {
            if ($dh = opendir($ruta)) {
                while (($file = readdir($dh)) !== false) {

                    if($file!="." && $file!="..") {

                        if (is_dir($ruta . $file)) {

                            $archivos = $this->listar_directorios_ruta($ruta . $file . "/",$version,$archivos);
                        }
                        else{
                            $modificacion = date("Y-m-d H:i:s", filemtime($ruta . $file));

                            if($modificacion>$version){
                                 echo date("Y-m-d H:i:s").": ".$file." archivo modificado ".PHP_EOL;
                                $archivos[] = $ruta . $file;
                            }
                        }
                    }
                }
                closedir($dh);

            }
            return $archivos;
        }else
            return "<br>No es ruta valida";
    }
}
