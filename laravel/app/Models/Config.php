<?php namespace App\Models;

use App\Libraries\Repositories\GeneralRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class Config extends Model {

    public $table = "configuracion";

    public $primaryKey = "id";

    protected $dates = [
        "created_at",
        "updated_at"
    ];

    public $timestamps = false;

    public $fillable = [
        "param"
        ,"valor"
    ];

    public static $rules = [

    ];

}
