<?php namespace App\Models\Game;

use Illuminate\Database\Eloquent\Model;

class Tablero extends Model {

    public $table = "tablero";

    public $primaryKey = "id";

    protected $dates = [
        "created_at",
        "updated_at"
    ];

    public $timestamps = true;

    public $fillable = [
        "numero",
        "color",
        "tipo",
        "mitad"
    ];

    public static $rules = [

    ];
    public static function getnumero(string $num): self
    {
        return self::where("numero",$num)->select("numero","color","tipo","mitad")->first();
    }

}
