<?php namespace App\Http\Controllers;

use App\GenericClass;
use App\Models\Admin\Licencia;
use App\Models\CFDI\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Response;

class ClienteController extends Controller
{
    public function __construct()
    {

        $this->middleware('auth');
        if(!Auth::guest())
            GenericClass::setConnectionByLicencia(Session::get("workspace"));
    }
    function index(){
        return view("clientes.index");
    }
    function create(){
        return view("clientes.create");
    }
    function guardaDatosReceptor(Request $request){
        $input = $request->all();
        try{
            if($input["id"]>0){
                $id = $input["id"];
                unset($input["id"]);
                unset($input["_token"]);
                Cliente::where("id",$id)->update($input);
            }
            else{
                Cliente::create($input);
            }

            return response()->json("Los datos se actualizaron correctamente",200);
        }
        catch (\Exception $e){
            return response()->json("[".$e->getLine()."] ".$e->getMessage(),500);
        }
    }
    function show(){

    }
    function datapanel(){

        $clientes = Cliente::orderby("Rfc")->paginate(1000);
        return view("clientes.datapanel")->with("clientes",$clientes);
    }
    function traerClientes(Request $request){
        try {
            $input = $request->all();
            $rfc = GenericClass::empresa()->Rfc;
            $conexion = DB::connection("admin")->table("conexiones")->where("clave", Session::get("workspace"))->where("sistema", 2)->first();
            GenericClass::setDinamico($conexion);
            $clientes = DB::connection("dinamico")->table("clientes")->where("Rfc","!=",$rfc)->get();
            foreach ($clientes as $cliente) {
                Cliente::updateOrCreate([
                    "Rfc" => $cliente->rfc
                ], [
                    "Nombre" => $cliente->nombre
                ]);
            }
            return response()->json("Los datos se actualizaron correctamente",200);
        }
        catch (\Exception $e){
            return response()->json("[".$e->getLine()."] ".$e->getMessage(),500);
        }
    }
    function borrarCliente(Request $request){
        $input = $request->all();
        try {
            Cliente::where("id", $input["id"])->delete();
            return response()->json("Los datos se actualizaron correctamente",200);
        }catch (\Exception $e){
            return response()->json("[".$e->getLine()."] ".$e->getMessage(),500);
        }
    }


}