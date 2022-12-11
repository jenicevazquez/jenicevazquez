<?php namespace App\Models\Cuentas;

use App\Libraries\Repositories\GeneralRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Cuenta extends Model {

    public $table = "cuentas";

    public $primaryKey = "id";

    protected $dates = [
        "created_at",
        "updated_at"
    ];

    public $timestamps = false;

    public $fillable = [
        "red"
        ,"nombre"
        ,"tipo"
        ,"numero"
        ,"digital"
        ,"saldo"
        ,"limite"
        ,"corte"
        ,"pago"
    ];

    public static $rules = [

    ];
    public function getDeudaAttribute(){
        return $this->limite-$this->saldo;
    }
    public function getUltimoCorteAttribute(){
        $ultimocorte = $this->cortes->sortByDesc("fechaCorte")->first();
        return $ultimocorte?? null;
    }
    public function getDeudaConCatAttribute(){
        $deuda = $this->deuda;
        $cat = $this->ultimo_corte->cat ?? 0;
        $virtual = ($deuda+($deuda*($cat/100)));
        return $virtual?? 0;
    }
    public function getTotalDeudaConCatAttribute()
    {
        $total = 0;
        $cuentas = Cuenta::get();
        foreach ($cuentas as $cuenta) {
            $total += $cuenta->deuda_con_cat;
        }
        return round($total,2);
    }
    public function getPorcentajeConCatAttribute(){
        $virtual = $this->deuda_con_cat;
        $totalvirtual = $this->total_deuda_con_cat;
        $porcentaje = round(($virtual*100)/$totalvirtual,2);
        return $porcentaje?? 0;
    }
    public function cortes()
    {
        return $this->hasMany('App\Models\Cuentas\Corte', 'cuenta_id');
    }

}
