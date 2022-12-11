<?php


namespace App\Http\Controllers;

use App\Libraries\Repositories\GeneralRepository;
use App\Models\Cuentas\Corte;
use App\Models\Cuentas\Cuenta;
use App\Models\Cuentas\Mercadolibre;
use App\Models\Cuentas\PagoTarjeta;
use App\Models\Game\Jugada;
use App\Models\Game\Patron;
use App\Models\Game\Prediccion;
use App\Models\Game\Tablero;
use App\Models\Game\Tirada;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\Game\Juego;
use Response;

class CuentaController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('cuentas.index');
    }
    function calculos(){
        $ml = Mercadolibre::where("mes",date("n")+1)->sum("mensualidad");
        $mlcorte = Corte::where("cuenta_id",5)->orderby("fechaCorte","desc")->first();
        $no = max($mlcorte->nointeres,$ml);
        Corte::where("id",$mlcorte->id)->update(array(
            "minimo"=>$no,
            "nointeres"=>$no
        ));

        $limite=0;
        $saldo=0;
        $semana = date('W');
        $totalMinimo = 0;
        $totalMinimoSemanal = 0;
        $totalMinimo2 = 0;
        $totalMinimoSemanal2 = 0;
        $totalCat = 0;
        $totalPagado = 0;
        $totalPendiente = 0;
        $totalSemanal = 0;
        $totalPorcentaje = 0;
        $totalnointeres = 0;
        $proximo_viernes=date ("Y-m-d",strtotime("next Friday"));
        $registros = Cuenta::all();
        $datos = [];
        foreach($registros as $registro){
            $limite+=$registro->limite;
            $s = max($registro->saldo, 0);
            $saldo+= $s;
            $totalCat+= $registro->ultimo_corte? $registro->ultimo_corte->cat:$registro->ultimo_corte2->cat;
            $totalPagado+= $registro->ultimo_corte? $registro->ultimo_corte->pagado:0;

            $starDate = "-";
            $starDate2 = "-";
            $semanas = "-";
            $semanas2 = "-";
            if($registro->ultimo_corte){
                $starDate = new \DateTime( $registro->ultimo_corte->fechaLimite);
                $semanas = $starDate->format('W')-$semana;
                $starDate2 = new \DateTime( $registro->ultimo_corte->fechaCorte);
                $semanas2 = $starDate2->format('W')-$semana;
                $semanas2 = 4+$semanas2*1;
            }
            else{
                $starDate3 = new \DateTime( $registro->ultimo_corte2->fechaCorte);
                $semanas2 = $starDate3->format('W')-$semana;
                $semanas2 = 4+$semanas2*1;
            }

            $totalMinimo += $registro->ultimo_corte? $registro->ultimo_corte->minimo:0;
            $totalnointeres += $registro->ultimo_corte? $registro->ultimo_corte->nointeres:0;
            $totalMinimoSemanal += ($totalMinimo/4);
            $totalMinimo2 += $registro->ultimo_corte? $registro->ultimo_corte->nointeres:0;
            $totalMinimoSemanal2 += ($totalMinimo2/4);
            $pagado = $registro->ultimo_corte? $registro->ultimo_corte->pagado:0;
            $minimo = $registro->ultimo_corte? $registro->ultimo_corte->minimo:0;
            $nointeres = $registro->ultimo_corte? $registro->ultimo_corte->nointeres:0;
            //$pagado = $pagado>$minimo? $minimo:$pagado;
            $pendiente = $registro->id!=5? $minimo-$pagado:$ml;
            $pendiente = max($pendiente, 0);
            $pagadopendiente = $registro->pagado_semana;
            $semanal = $semanas>0? $pendiente/$semanas:$pendiente;
            $semanal = $pagadopendiente>$semanal? 0:$semanal;
            $totalSemanal+=$semanal;
            $porcentaje = $registro->porcentaje_con_cat;
            $totalPorcentaje+=$porcentaje;
            $totalPendiente+=$pendiente;
            $temp = [
                "saldo"=> $registro->saldo,
                "porcentaje"=> $porcentaje,
                "id"=>$registro->id,
                "nombre"=>$registro->nombre,
                "red"=>$registro->red,
                "numero"=>$registro->numero,
                "digital"=>$registro->digital,
                "limite"=>$registro->limite,
                "deuda"=>$registro->deuda,
                "deudaconcat"=>$registro->deuda_con_cat,
                "ultimoCorte"=>$registro->ultimo_corte? $registro->ultimo_corte->cat:$registro->ultimo_corte2->cat,
                "fechaCorte"=>$registro->ultimo_corte? $registro->ultimo_corte->fechaCorte:"-",
                "fechaLimite" => $registro->ultimo_corte? $registro->ultimo_corte->fechaLimite:"-",
                "semanas2"=>$semanas2,
                "semanas"=>$semanas,
                "minimo"=>$minimo,
                "nointeres"=>$nointeres,
                "minimoSemanal"=>$registro->ultimo_corte? $registro->ultimo_corte->minimo/4:0,
                "noInteres"=>$registro->ultimo_corte?$registro->ultimo_corte->nointeres:0,
                "noInteresSemanal"=>$registro->ultimo_corte? $registro->ultimo_corte->nointeres/4:0,
                "pagado"=>$pagado,
                "pendiente"=>$pendiente,
                "semanal"=>$semanal,
                "pagadosemana"=>$pagadopendiente

            ];
            $datos[] = $temp;
        }

        foreach ($datos as $clave => $fila) {
            $column[$clave] = $fila['deudaconcat'];
        }
        array_multisort($column, SORT_DESC, $datos);
        $foot = (object)[
            "limite"=>$limite,
            "saldo"=>$saldo,
            "deuda"=>$limite-$saldo,
            "totalCat"=>$totalCat,
            "totalPorcentaje"=>$totalPorcentaje,
            "totalnointeres"=>$totalnointeres,
            "totalMinimo"=>$totalMinimo,
            "totalMinimoSemanal"=>$totalMinimoSemanal,
            "totalMinimo2"=>$totalMinimo2,
            "totalMinimoSemanal2"=>$totalMinimoSemanal2,
            "totalPagado"=>$totalPagado,
            "totalPendiente"=>$totalPendiente,
            "totalSemanal"=>$totalSemanal,
            "proximo_viernes"=>$proximo_viernes
        ];
        foreach ($datos as $i=>$dato) {
            $datos[$i] = (object)$dato;
        }
        return [$datos,$registros,$foot];
    }
    public function listCuentas(Request $request){
        $input = $request->all();
        $abono = $input["abono"]?? "";
        $resultado = $this->calculos();
        $datos = $resultado[0];
        $registros = $resultado[1];
        $foot = $resultado[2];
        $fridays = $this->fridays_get();
        return [
            view("cuentas.dataCuentas2")->with("registros",$datos)->with("fridays",$fridays)->with("foot",$foot)->with("abono",$abono)->render(),
            view("cuentas.cuadroCuentas")->with("registros",$registros)->render()
        ];
    }
    function fridays_get() {

        $startTime = strtotime( date('Y-m-d') );
        $future_timestamp = strtotime("+2 month");
        $data = date('Y-m-d', $future_timestamp);
        $endTime = strtotime( $data );
        $fridays = [];
        // Loop between timestamps, 24 hours at a time
        for ( $i = $startTime; $i <= $endTime; $i = $i + 86400 ) {
            $thisDate = date( 'Y-m-d', $i ); // 2010-05-01, 2010-05-02, etc
            if(date('w', strtotime($thisDate))==5&&count($fridays)<4){
                $fridays[] = $thisDate;
            }
        }
        return $fridays;
    }

    public function listMercadoLibre(){
        $mercadolibre = Mercadolibre::all();
        return [
            view("cuentas.dataMercado")->with("mercadolibre",$mercadolibre)->render()
        ];
    }
    public function listPagos(Request $request){
        $input = $request->all();
        $cuenta = Cuenta::find($input["id"]);
        return [
            view("cuentas.dataCuentas3")->with("registro",$cuenta)->render()
        ];
    }
    public function pdf($id){
        $corte = Corte::find($id);
        $fechaCorte = $corte->fechaCorte;
        $directory = storage_path().'\\bancos\\'.$fechaCorte.".pdf";
        if(is_file($directory) && file_exists($directory)) {
            $name = $directory;
            $mime = mime_content_type($name);
            return Response::make(file_get_contents($name), 200, [
                'Content-Type' => $mime,
                'Content-Disposition' => 'inline; ' . $name,
            ]);
        }
        else{
            return false;
        }
    }
    public function storeCuentas(Request $request){
        $input = $request->all();
        Cuenta::create($input);
    }
    public function storeCorte(Request $request){
        $input = $request->all();
        Corte::create($input);
    }
    public function storePagos(Request $request){
        $input = $request->all();
        $input["fechaPago"] = date("Y-m-d");
        PagoTarjeta::create($input);
    }
    public function storeSaldo(Request $request){
        $input = $request->all();
        $id = $input["id"];
        $operacion = $input["operacion"];
        if($operacion==1){
            if($input["agregar"]=="1") {
                Cuenta::where("id", $id)->update(array(
                    "saldo" => DB::raw("saldo+" . $input["saldo"])
                ));
            }
            PagoTarjeta::create(array(
               "fechaPago"=>DB::raw("NOW()"),
                "cantidad"=>$input["saldo"],
                "cuenta_id"=>$id
            ));
        }
        else if($operacion==2){
            Cuenta::where("id",$id)->update(array(
                "saldo"=> DB::raw("saldo-".$input["saldo"])
            ));
        }
        else{
            Cuenta::where("id",$id)->update(array(
                "saldo"=>$input["saldo"]
            ));
        }

    }

}