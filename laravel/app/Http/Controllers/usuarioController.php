<?php namespace App\Http\Controllers;


use App\Libraries\Repositories\GeneralRepository;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class usuarioController extends Controller {
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
	    $diccionario = array(
	        "usuario"   => "users.name"
        );
	    $input = $request->all();
        $input["perpage"] = (isset($input["perpage"]))? $input["perpage"]:25;

        $query = User::select('users.*');

        $query = GeneralRepository::busquedaSort($query,$diccionario,$input);
        $query->where("licencia_id",Auth::user()->licencia_id);
        if(!isset($input["sort"])){
            $query->orderby("role_id", "asc")->orderby("name", "asc");
        }
        $usuarios = $query->paginate($input["perpage"]);


        return view("usuarios.index")->with("usuarios",$usuarios)->with("q",$input);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        return view("usuarios.create");
	}


	public function store(Request $request)
	{
	    $input = $request->all();
        $input["licencia_id"] = (!isset($input["licencia_id"]))? Auth::user()->licencia_id:$input["licencia"];
        $input["admin"] = 0;
        $input["password"] = bcrypt($input["password"]);
        if($request->hasFile('imagen')){
            $file = $request->file('imagen');
            $nombre = $file->getClientOriginalName();
            $nombre = GeneralRepository::limpiaFilename($nombre);

            $upload = storage_path() . '/data/' . $input["licencia_id"];

            if (!file_exists($upload)) {
                mkdir($upload, 0777, true);
            }
            $file->move($upload, $nombre);

            flush();
            ob_flush();

            $input["imagen"] = $nombre;
        }
        User::create($input);
        return redirect(route('usuarios.index'));
	}

	/**
	 * Display the specified resource.
	 *
	 *
	 * @return Response
	 */
	public function show($id)
	{

	    $usuario = User::find($id);
		return view("usuarios.show")->with("usuario",$usuario);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
	    $usuario = User::find($id);
        return view("usuarios.edit")->with("usuario",$usuario);
	}

	/**
	 * Update the specified resource in storage.
	 * @param $request
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, Request $request)
	{
        $input      =   $request->all();
        $input["licencia_id"] = (!isset($input["licencia_id"]))? Auth::user()->licencia_id:$input["licencia"];
        $upload = storage_path() . '/data/' . $input["licencia_id"];

        $usuario = User::find($id);
        if($usuario->imagen!=null){
            if (file_exists($upload.'/'.$usuario->imagen)) {
                unlink($upload.'/'.$usuario->imagen);
            }
        }

        if($input["password"]==""){
            unset($input["password"]);
        }
        else{
            $input["password"] = bcrypt($input["password"]);
        }

        if($request->hasFile('imagen')){
            $file = $request->file('imagen');
            $nombre = $file->getClientOriginalName();
            $nombre = GeneralRepository::limpiaFilename($nombre);

            if (!file_exists($upload)) {
                mkdir($upload, 0777, true);
            }
            $file->move($upload, $nombre);

            $input["imagen"] = $nombre;
        }
        else{
            unset($input["imagen"]);
        }

        $usuario->fill($input);
        $usuario->save();
        //dd($input);
        return redirect(route('usuarios.index'));

	}

	public function destroy($id)
	{
        $usuario = User::find($id);
        if($usuario!=null)
            $usuario->delete();

        return redirect(route('usuarios.index'));
	}
    public function vercomo(Request $request){
        $input = $request->all();
        $id = $input["id"];
        $myid = Auth::user()->id;
        $usuario = User::find($myid);
        $usuario->fill(array(
            "licencia_id"=>$id
        ));
        $usuario->save();
        return $id;
    }
    public function activo(Request $request){
        $input = $request->all();
        if($input["activo"]==1){
            User::where('id',$input["id"])->update(array('activo' => '0'));
        } else {
            User::where('id',$input["id"])->update(array('activo' => '1'));
        }

	    return $input["id"];
    }

}
