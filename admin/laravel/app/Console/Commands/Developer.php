<?php namespace App\Console\Commands;


use App\Libraries\Repositories\GeneralRepository;
use App\Model\Cancelacion;
use App\Model\Corte;
use App\Model\Movimiento;
use App\Model\Salida;
use App\Model\Traspaso;
use App\Model\TraspasoItem;
use App\Model\Usuario;
use App\Model\UsuarioLocal;
use App\Model\UsuarioSucursal;
use App\Model\Venta;
use App\Model\Visita;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use ZipArchive;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;
use GuzzleHttp;
use App\Model\Producto;
use App\Model\Sucursal;
use App\Model\Inventario;

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

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        $licencia = 1;
        GeneralRepository::setConnection($licencia);

        $anterior = '2012';
        $nuevo = '3';

        Cancelacion::where("created_by",$anterior)->update(array(
            "created_by"=>$nuevo
        ));
        Corte::where("created_by",$anterior)->update(array(
            "created_by"=>$nuevo
        ));
        Movimiento::where("created_by",$anterior)->update(array(
            "created_by"=>$nuevo
        ));
        Producto::where("created_by",$anterior)->update(array(
            "created_by"=>$nuevo
        ));
        Salida::where("usuario",$anterior)->update(array(
            "usuario"=>$nuevo
        ));
        Traspaso::where("created_by",$anterior)->update(array(
            "created_by"=>$nuevo
        ));
        TraspasoItem::where("confirmed_by",$anterior)->update(array(
            "confirmed_by"=>$nuevo
        ));
        Venta::where("created_by",$anterior)->update(array(
            "created_by"=>$nuevo
        ));
        UsuarioSucursal::where("user_id",$anterior)->update(array(
            "user_id"=>$nuevo
        ));
        Visita::where("usuario",$anterior)->update(array(
            "usuario"=>$nuevo
        ));

        return;
        /*
        $productos = Producto::all();
        $sucursales = Sucursal::all();

        foreach ($productos as $producto){
            echo $producto->id."-";
            foreach ($sucursales as $sucursal){
                echo $sucursal->id;
                Inventario::updateOrCreate([
                    "sucursal_id"=>$sucursal->id,
                    "producto_id"=>$producto->id
                ],[
                    "stock"=>100
                ]);
            }
            echo PHP_EOL;
        }
*/
        /*SEPOMEX (CODIGOS POSTALES)*/
        /*
        $registros = DB::connection("mysql")->table("sepomex")->get();
        echo "TOTAL: ".count($registros);
        $bar = $this->output->createProgressBar(count($registros));
        foreach ($registros as $registro){
            DB::connection("admin")->table("sepomex")->insert(array(
                "idEstado"=>$registro->idEstado
                ,"estado"=>$registro->estado
                ,"idMunicipio"=>$registro->idMunicipio
                ,"municipio"=>$registro->municipio
                ,"ciudad"=>$registro->ciudad
                ,"zona"=>$registro->zona
                ,"cp"=>$registro->cp
                ,"asentamiento"=>$registro->asentamiento
                ,"tipo"=>$registro->tipo
            ));
            $bar->advance();
        }
        $bar->finish();*/

        /*PAISES*/
        /*$registros = DB::connection("mysql")->table("paises")->get();
        echo "TOTAL: ".count($registros);
        $bar = $this->output->createProgressBar(count($registros));
        foreach ($registros as $registro){
            DB::connection("admin")->table("paises")->insert(array(
                "iso"=>$registro->iso
            ,"nombre"=>$registro->nombre
            ));
            $bar->advance();
        }
        $bar->finish();*/

    }

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

}
