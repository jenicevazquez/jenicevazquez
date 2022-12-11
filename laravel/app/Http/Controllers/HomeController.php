<?php


namespace App\Http\Controllers;
use App\Models\Blog\Articulo;
use App\Models\Cuentas\Mercadolibre;
use Response;


class HomeController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        return view('home');
    }
    function reportes(){
        return view("expediente.reportes.index");
    }
    function welcome(){
        $articulos = Articulo::orderby("created_at","desc")->get();
        return view('welcome')->with("articulos",$articulos);
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
        return view('sitio.category');
    }
    function blogTipo($tipo){
        return view('sitio.tipos.standard');
    }
}