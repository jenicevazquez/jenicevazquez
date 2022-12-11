<?php namespace App\Models\Game;

use Illuminate\Database\Eloquent\Model;

class Prediccion extends Model {

    public $table = "predicciones";

    public $primaryKey = "id";

    protected $dates = [
        "created_at",
        "updated_at"
    ];

    public $timestamps = true;

    public $fillable = [
        "juego_id",
        "tipo",
        "valor",
        "probabilidad",
        "exitoso",
        "prediccion"
    ];

    public static $rules = [

    ];


}
