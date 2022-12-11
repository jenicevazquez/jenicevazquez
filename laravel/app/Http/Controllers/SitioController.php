<?php


namespace App\Http\Controllers;
use App\Models\Blog\Articulo;
use App\Models\Blog\ArticuloCategoria;
use Response;


class SitioController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    public function index()
    {
        $articulos = Articulo::orderby("created_at","desc")->get();
        return view('sitio.index')->with("articulos",$articulos);
    }
    function contact(){
        return view('sitio.contact');
    }
    function about(){
        return view('sitio.about');
    }
    function projects(){
        return view('sitio.projects');
    }
    function blogCategoria($categoria){
        $categoria = ArticuloCategoria::where("enlace",$categoria)->first();
        return view('sitio.category')->with("categoria",$categoria);
    }
    function blogTipo($tipo){
        return view('sitio.tipos.'.$tipo);
    }
    function blogShow($id,$slug){
        $articulo = Articulo::find($id);
        $articulo->increment("visitas");
        $tipo = $articulo->tipo;
        return view('sitio.tipos.'.$tipo)->with("articulo",$articulo);
    }
}