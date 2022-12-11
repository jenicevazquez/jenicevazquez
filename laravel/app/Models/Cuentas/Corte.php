<?php namespace App\Models\Cuentas;

use App\Libraries\Repositories\GeneralRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Corte extends Model {

    public $table = "cortes";

    public $primaryKey = "id";

    protected $dates = [
        "created_at",
        "updated_at"
    ];

    public $timestamps = false;

    public $fillable = [
        "fechaCorte"
        ,"fechaLimite"
        ,"minimo"
        ,"nointeres"
        ,"cat"
        ,"cuenta_id"
        ,"impuestos"
    ];

    public static $rules = [

    ];
    public function cuenta()
    {
        return $this->hasOne('App\Models\Cuentas\Cuenta', 'cuenta_id');
    }
    public function getPagosAttribute()
    {
        return PagoTarjeta::whereRaw("cuenta_id = '".$this->cuenta_id."' AND fechaPago>='".$this->fechaCorte."' AND fechaPago<='".$this->fechaLimite."'")->get();
        //return $this->hasMany('App\Models\Cuentas\PagoTarjeta', 'corte_id');
    }

    public function getPagadoAttribute(){
        return $this->pagos? $this->pagos->sum("cantidad"):0;
    }


}
