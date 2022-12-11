<?php namespace App\Models\Game;

use Illuminate\Database\Eloquent\Model;

class Jugada extends Model {

    public $table = "jugadas";

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
        "mitad"
    ];

    public static $rules = [

    ];
    public static function addJugada(Tablero $tirada,int $id): self
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
