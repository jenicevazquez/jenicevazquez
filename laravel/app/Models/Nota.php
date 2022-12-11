<?php namespace App\Models;

use App\Libraries\Repositories\GeneralRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class Nota extends Model {

    public $table = "notas";

    public $primaryKey = "id";

    protected $dates = [
        "created_at",
        "updated_at"
    ];

    public $timestamps = true;

    public $fillable = [
        "titulo"
        ,"texto"
        ,"categoria"
        ,"compartidos"
    ];

    public static $rules = [

    ];

    public function comentarios()
    {
        return $this->hasMany('App\Models\NotaComentario', 'nota_id');
    }
    public function likes()
    {
        return $this->hasMany('App\Models\NotaLikes', 'nota_id');
    }
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
    public function getMegustaAttribute(){
        $userid = Auth::user()->id;
        $like = NotaLikes::where("user_id",$userid)->where("nota_id",$this->id)->first();
        if($like){
            return true;
        }
        else{
            return false;
        }
    }

}
