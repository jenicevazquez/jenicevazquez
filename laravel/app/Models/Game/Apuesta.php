<?php namespace App\Models\Game;

use Illuminate\Database\Eloquent\Model;

class Apuesta extends Model {

    public $table = "apuestas";

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
        "exitoso",
        "factor",
        "prediccion_id",
        "doble",
        "cantidad",
        "probabilidad",
        "activo"
    ];

    public static $rules = [

    ];
    public function juego()
    {
        return $this->hasOne('App\Models\Game\Juego', 'juego_id');
    }
    public static function factor($tipo,$id){
        $ultimo = (new static)::where('tipo', $tipo)->where("juego_id",$id)->whereNotNull('exitoso')->orderby("id","desc")->first();
        $factor = 1;
        if($ultimo){
            if($ultimo->exitoso==0){
                $factor = $ultimo->factor+1;
            }
        }

        return $factor;
    }
    public static function cantidad($tipo,$id){
        $ultimo = (new static)::where('tipo', $tipo)->where("juego_id",$id)->whereNotNull('exitoso')->orderby("id","desc")->first();
        $juego = Juego::where("id",$id)->first();
        $factor = $juego->inicial;
        if($ultimo){
            if($ultimo->exitoso==0){
                $factor = $ultimo->cantidad*2;
            }
        }

        return $factor;
    }


}
