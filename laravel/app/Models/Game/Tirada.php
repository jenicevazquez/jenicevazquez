<?php namespace App\Models\Game;

use Illuminate\Database\Eloquent\Model;

class Tirada extends Model {

    public $table = "tiradas";

    public $primaryKey = "id";

    protected $dates = [
        "created_at",
        "updated_at"
    ];

    public $timestamps = true;

    public $fillable = [
        "juego_id",
        "numero",
        "color",
        "tipo",
        "mitad",
        "jugada_id"
    ];

    public static $rules = [

    ];
    public static function addTirada(Tablero $tirada,int $id): self
    {
        return self::create([
            'numero' => $tirada->numero,
            'color' => $tirada->color,
            'tipo' => $tirada->tipo,
            'mitad' => $tirada->mitad,
            'juego_id' => $id
        ]);
    }

}
