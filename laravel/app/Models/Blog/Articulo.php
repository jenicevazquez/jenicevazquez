<?php namespace App\Models\Blog;

use App\Libraries\Repositories\GeneralRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Articulo extends Model {

    public $table = "articulos";

    public $primaryKey = "id";

    protected $dates = [
        "created_at",
        "updated_at"
    ];

    public $timestamps = true;

    public $fillable = [
        "titulo"
        ,"imagen"
        ,"texto"
        ,"categoria"
        ,"tipo"
        ,"visitas"
        ,"autor"
        ,"description"
    ];

    public static $rules = [

    ];
    public function categoriaRow()
    {
        return $this->belongsTo('App\Models\Blog\ArticuloCategoria', 'categoria');
    }
    public function autorRow()
    {
        return $this->belongsTo('App\User', 'autor');
    }
    public function tags()
    {
        return $this->hasMany('App\Models\Blog\ArticuloTag', 'articulo_id');
    }
    public function archivos()
    {
        return $this->hasMany('App\Models\Blog\Archivo', 'articulo_id');
    }
    public function getFechaStrAttribute(){
        $meses = ["","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"];
        $created = $this->created_at;
        $partes = explode(" ",$created);
        list($anio,$mes,$dia) = explode("-",$partes[0]);
        return $meses[$mes]." ".$dia.", ".$anio;
    }
    public function getSlugAttribute(){
        return Str::slug($this->titulo, '-');;
    }

}
