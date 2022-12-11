<?php namespace App\Models\Cuentas;

use App\Libraries\Repositories\GeneralRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Mercadolibre extends Model {

    public $table = "mercadolibre";

    public $primaryKey = "id";

    protected $dates = [
        "created_at",
        "updated_at"
    ];

    public $timestamps = false;

    public $fillable = [
        "folio"
        ,"producto"
        ,"mensualidad"
        ,"num"
        ,"pagados"
        ,"mes"
    ];

    public static $rules = [

    ];

}
