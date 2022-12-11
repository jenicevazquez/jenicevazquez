<?php


namespace App\Http\Controllers;

use App\Libraries\Repositories\GeneralRepository;
use App\Models\Blog\Articulo;
use App\Models\Blog\ArticuloArchivo;
use App\Models\Blog\ArticuloTag;
use Illuminate\View\View;
use Illuminate\Http\Request;

class BlogController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $articulos = Articulo::paginate(15);
        return view('blog.index')->with("articulos",$articulos);
    }
    public function create()
    {

        return view('blog.create');
    }
    public function store(Request $request)
    {
        $input = $request->all();
        $articulo = Articulo::create(array(
            "titulo"=>$input["titulo"],
            "categoria"=>$input["categoria"],
            "tipo"=>$input["tipo"],
            "texto"=>$input["texto"]
        ));
        if(isset($input["links"])) {
            foreach ($input["links"] as $link) {
                ArticuloArchivo::create(array(
                    "archivo" => $link,
                    "formato" => "enlace",
                    "articulo_id" => $articulo->id
                ));
            }
        }
        if(isset($input["archivos"])) {
            $files = $request->file('archivos');
            foreach ($files as $i => $file) {
                if ($request->hasFile('archivos')) {
                    set_time_limit(0);
                    $extension = $file->getClientOriginalExtension();
                    $nombre = $file->getClientOriginalName();
                    $upload = public_path() . "/blogFiles/";
                    $file->move($upload, $nombre);
                    ArticuloArchivo::create(array(
                        "archivo" => $nombre,
                        "formato" => $extension,
                        "articulo_id" => $articulo->id
                    ));
                }

            }
            if(isset($input["tags"])) {
                foreach ($input["tags"] as $link) {
                    ArticuloTag::create(array(
                        "etiqueta" => $link,
                        "articulo_id" => $articulo->id
                    ));
                }
            }
        }
    }
    function destroy($id){
        $juego = Articulo::find($id);
        $juego->categoriaRow()->delete();
        $juego->delete();
    }


}