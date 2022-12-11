<?php namespace App\Models\Blog;

use App\Libraries\Repositories\GeneralRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ArticuloTag extends Model {

    public $table = "articulosTag";

    public $primaryKey = "id";

    protected $dates = [
        "created_at",
        "updated_at"
    ];

    public $timestamps = false;

    public $fillable = [
        "etiqueta",
        "articulo_id"
    ];

    public static $rules = [

    ];


}
