<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Libraries\Repositories\GeneralRepository;
use App\Models\Perfil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PerfilController extends Controller {
    public function __construct()
    {

        $this->middleware('auth');
    }

    public function index(Request $request)
    {

        $roles = Perfil::where("licencia", Auth::user()->licencia_id)->get();
        $q = $request->all();

        return view("roles.index")->with('roles', $roles)->with('q', $q);
    }
    public function permisosLicencia(){
        $permisos = DB::table("modulos_licencia")->where("id_licencia",Auth::user()->licencia_id)
            ->leftjoin("permisos", "permisos.sistema_id","=","modulos_licencia.id_modulo")
            ->select("permisos.*")->get();
        return $permisos;
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $permisos = $this->permisosLicencia();
        return view("roles.create")->with("permisos",$permisos);
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $permisos = (isset($input["modulo"]))? $input["modulo"]:[];
        unset($input["modulo"]);
        $input["licencia"] = Auth::user()->licencia_id;
        $perfil = Perfil::create($input);

        foreach ($permisos as $permiso){
            DB::table("permisos_perfil")->insert(array(
                "perfil_id" =>  $perfil->id,
                "permiso_id"=>  $permiso
            ));
        }
        return redirect(route('perfiles.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $permisos = $this->permisosLicencia();
        $perfil = Perfil::find($id);
        $permisosUser = DB::table("permisos_roles")->where("roles_id",$id)->lists("permiso_id");
        return view('roles.edit')->with("permisos",$permisos)->with('role',$perfil)->with('permisosUser',$permisosUser);
    }

    public function update(Request $request,$id)
    {
        $input = $request->all();

        $permisos = (isset($input["modulo"]))? $input["modulo"]:[];
        unset($input["modulo"]);

        $perfil = Perfil::find($id);
        $perfil->fill($input);
        $perfil->save();

        DB::table("permisos_roles")->where('roles_id',$id)->delete();

        foreach ($permisos as $permiso){
            DB::table("permisos_roles")->insert(array(
                "roles_id" =>  $id,
                "permiso_id"=>  $permiso
            ));
        }
        return redirect(route('perfiles.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $perfil = Perfil::find($id);
        $perfil->delete();
        DB::table("sistemas_perfil")->where('perfil_id',$id)->delete();
        DB::table("permisos_perfil")->where('perfil_id',$id)->delete();
        return redirect(route('perfiles.index'));
    }

}
