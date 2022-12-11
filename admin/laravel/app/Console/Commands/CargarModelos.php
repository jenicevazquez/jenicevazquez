<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\GenericClass;


class CargarModelos extends Command
{

    protected $signature = 'task:cargarModelos';
    protected $description = 'Copiar modelos';
    public function __construct()
    {
        parent::__construct();
    }
    public function handle()
    {
        $folder = "\A20";
        $path = "C:\RYVConsultores\core\Models".$folder;
        $path2 = app_path() . "\Models".$folder;
        $folders = GenericClass::obtenerArchivos($path);
        foreach ($folders as $folder) {
            if (is_dir($path . "\\" . $folder)) {
                GenericClass::checkandcreatePath($path2 . "\\" . $folder);
                $archivos = GenericClass::obtenerArchivos($path . "\\" . $folder);
                foreach ($archivos as $archivo) {
                    $contents = "<?php require('" . $path . "\\" . $folder . "\\" . $archivo . "');";
                    file_put_contents($path2 . "\\" . $folder . "\\" . $archivo, $contents);
                }
            } else {
                GenericClass::checkandcreatePath($path2);
                $archivo = $folder;
                $contents = "<?php require('" . $path . "\\" . $archivo . "');";
                file_put_contents($path2 . "\\" . $archivo, $contents);
            }

        }
    }

}
