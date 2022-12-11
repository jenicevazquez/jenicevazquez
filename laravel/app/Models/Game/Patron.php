<?php namespace App\Models\Game;

use Illuminate\Database\Eloquent\Model;

class Patron extends Model {

    public $table = "patrones";

    public $primaryKey = "id";

    protected $dates = [
        "created_at",
        "updated_at"
    ];

    public $timestamps = false;

    public $fillable = [
        "tipo",
        "patron",
        "conteo"
    ];

    public static $rules = [

    ];

}
