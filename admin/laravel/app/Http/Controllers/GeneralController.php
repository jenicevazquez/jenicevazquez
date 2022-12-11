<?php namespace App\Http\Controllers;


use App\Models\Cfdi\Producto;
use App\Models\cfdi40\CClaveProdServ;
use App\Models\cfdi40\CClaveUnidad;
use App\Models\cfdi40\CCodigoPostal;
use App\Models\cfdi40\CObjetoImp;
use App\Models\Cfdi\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use App\GenericClass;
use Response;

class GeneralController extends Controller
{
    public function __construct()
    {

        $this->middleware('auth');
        if(!Auth::guest())
            GenericClass::setConnectionByLicencia(Session::get("workspace"));
    }
    function partialReload(Request $request){
        $input = $request->all();
        $vista = $input["src"];
        $q = $input["valores"];
        return view($vista)->with("q",$q)->render();
    }
    function getProdServ(Request $request){
        $input = $request->all();
        $query = CClaveProdServ::select(DB::raw("c_claveprodserv + ' - ' + descripcion as text"),DB::raw("c_claveprodserv as id"));
        if(isset($input["q"])) {
            $query->whereRaw("(c_claveprodserv like '%" . $input["q"] . "%' OR descripcion like '%" . $input["q"] . "%')");
        }
        $claves = $query->paginate(1000,['*'],'page',$input["page"]);
        return ["results"=>$claves,"pagination"=> ["more"=> true]];
    }
    function getClaveUnidad(Request $request){
        $input = $request->all();
        $query = CClaveUnidad::select(DB::raw("c_claveunidad + ' - ' + nombre as text"),DB::raw("c_claveunidad + ' - ' + nombre as id"));
        if(isset($input["q"])) {
            $query->whereRaw("(c_claveunidad like '%" . $input["q"] . "%' OR nombre like '%" . $input["q"] . "%')");
        }
        $claves = $query->paginate(1000,['*'],'page',$input["page"]);
        return ["results"=>$claves,"pagination"=> ["more"=> true]];
    }
    function getObjetoImp(Request $request){
        $input = $request->all();
        $query = CObjetoImp::select(DB::raw("c_objetoimp + ' - ' + descripcion as text"),'id');
        if(isset($input["q"])) {
            $query->whereRaw("(c_objetoimp like '%" . $input["q"] . "%' OR descripcion like '%" . $input["q"] . "%')");
        }
        $claves = $query->paginate(1000,['*'],'page',$input["page"]);
        return ["results"=>$claves,"pagination"=> ["more"=> true]];
    }
    function getCliente(Request $request){
        $input = $request->all();
        $query = Cliente::select(DB::raw("Rfc + ' - ' + Nombre as text"),"id");
        if(isset($input["q"])) {
            $query->whereRaw("(Rfc like '%" . $input["q"] . "%' OR Nombre like '%" . $input["q"] . "%')");
        }
        $claves = $query->paginate(10,['*'],'page',$input["page"]);
        return ["results"=>$claves,"pagination"=> ["more"=> true]];
    }
    function getLugarExpedicion(Request $request){
        $input = $request->all();
        $query = CCodigoPostal::select(DB::raw("c_codigopostal AS text"),'c_codigopostal as id');
        if(isset($input["q"])) {
            $query->whereRaw("(c_codigopostal like '%" . $input["q"] . "%' OR c_codigopostal like '%" . $input["q"] . "%')");
        }
        $claves = $query->paginate(1000,['*'],'page',$input["page"]);
        return ["results"=>$claves,"pagination"=> ["more"=> true]];
    }
    function NoIdentificacion(Request $request){
        $input = $request->all();
        $query = Producto::select(DB::raw("CodigoMercanciaProducto + ' - ' + DescripcionMercancia AS text"),'CodigoMercanciaProducto as id');
        if(isset($input["q"])) {
            $query->whereRaw("(CodigoMercanciaProducto like '%" . $input["q"] . "%' OR DescripcionMercancia like '%" . $input["q"] . "%')");
        }
        $claves = $query->paginate(1000,['*'],'page',$input["page"]);
        return ["results"=>$claves,"pagination"=> ["more"=> true]];
    }
}