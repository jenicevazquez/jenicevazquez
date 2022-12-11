<?php namespace App\Models\Blog;

use App\Libraries\Repositories\GeneralRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ArticuloArchivo extends Model {

    public $table = "articulosArchivos";

    public $primaryKey = "id";

    protected $dates = [
        "created_at",
        "updated_at"
    ];

    public $timestamps = false;

    public $fillable = [
        "archivo",
        "formato",
        "articulo_id"
    ];

    public static $rules = [

    ];


}
