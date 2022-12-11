<?php namespace App\Models\Cuentas;

use App\Libraries\Repositories\GeneralRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PagoTarjeta extends Model {

    public $table = "pagostarjetas";

    public $primaryKey = "id";

    protected $dates = [
        "created_at",
        "updated_at"
    ];

    public $timestamps = false;

    public $fillable = [
        "fechaPago"
        ,"cantidad"
        ,"corte_id"
        ,"cuenta_id"
    ];

    public static $rules = [

    ];


}
