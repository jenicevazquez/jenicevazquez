<?php namespace App\Models;

use App\Libraries\Repositories\GeneralRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class NotaComentario extends Model {

    public $table = "notasComentarios";

    public $primaryKey = "id";

    protected $dates = [
        "created_at",
        "updated_at"
    ];

    public $timestamps = true;

    public $fillable = [
        "nota_id"
        ,"user_id"
        ,"comentario"
        ,"likes"
    ];

    public static $rules = [

    ];

    public function autor()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

}
