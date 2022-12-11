<?php namespace App\Models\Game;

use Illuminate\Database\Eloquent\Model;

class Racha2 extends Model {

    public $table = "rachas2";

    public $primaryKey = "id";

    protected $dates = [
        "created_at",
        "updated_at"
    ];

    public $timestamps = false;

    public $fillable = [
        "tipo",
        "valor",
        "racha",
        "conteo",
        "salidas"
    ];

    public static $rules = [

    ];

}
