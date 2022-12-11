<?php namespace App\Http\Controllers;

use App\Libraries\Repositories\GeneralRepository;
use App\Models\Config1;
use App\Models\Licencia;
use App\Models\Permiso;
use App\Models\usuario;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PermisoController extends Controller {
    public function __construct()
    {

        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     * @param $request
     * @return Response
     */
    public function index(Request $request)
    {
        $input = $request->all();

        $diccionario = array(

        );
        $query = Permiso::select();
        $query = GeneralRepository::busquedaSort($query,$diccionario,$input);

        $noticias = $query->paginate(25);

        return view('permisos.index')->with("licencias",$noticias)->with("q",$input);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('permisos.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param $request
     * @return Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        Permiso::create($input);
        return redirect(route("permisos.index"));
    }

    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $licencia = Permiso::find($id);

        return view('permisos.edit')->with("licencia",$licencia)->with("id",$id);
    }

    public function update($id, Request $request)
    {
        $licencias = Permiso::find($id);
        $input = $request->all();
        $licencias->fill($input);
        $licencias->save();

        return redirect(route("permisos.index"));
    }

    public function destroy($id)
    {
        $vucem = Permiso::find($id);
        $vucem->delete();

        return redirect(route("permisos.index"));
    }

}
