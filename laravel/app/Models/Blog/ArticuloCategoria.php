<?php namespace App\Models\Blog;

use App\Libraries\Repositories\GeneralRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ArticuloCategoria extends Model {

    public $table = "articulosCategoria";

    public $primaryKey = "id";

    protected $dates = [
        "created_at",
        "updated_at"
    ];

    public $timestamps = false;

    public $fillable = [
        "categoria"
        ,"enlace"
        ,"descripcion"
    ];

    public static $rules = [

    ];


}
