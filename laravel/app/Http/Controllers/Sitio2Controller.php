<?php


namespace App\Http\Controllers;
use App\Models\NotaLikes;
use Illuminate\Support\Facades\Auth;
use App\Models\NotaComentario;
use Illuminate\Http\Request;
use App\Models\Nota;
use App\User;
use Response;


class Sitio2Controller extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    public function notas()
    {
        $notas = Nota::orderby("id","desc")->get();
        return view('sitio2.notas')->with("notas",$notas);
    }
    public function services()
    {
        return view('sitio2.services');
    }
    public function skills()
    {
        return view('sitio2.skills');
    }
    public function experience()
    {
        return view('sitio2.experience');
    }
    public function work()
    {
        return view('sitio2.work');
    }
    public function contact()
    {
        return view('sitio2.contact');
    }
    public function show()
    {
        return view('sitio2.show');
    }
    public function all()
    {
        return view('sitio2.all');
    }
    public function storenotas(Request $request)
    {
        $input = $request->all();
        Nota::create($input);
        return redirect("/v2/notas");
    }
    public function register(Request $request){
        $input = $request->all();
        $user = User::create($input);
        Auth::login($user);
    }
    public function comentar(Request $request){
        $input = $request->all();
        $userid = Auth::user()->id;
        NotaComentario::create(array(
            "nota_id"=>$input["id"]
            ,"user_id"=>$userid
            ,"comentario"=>$input["comentario"]
            ,"likes"=>0
        ));
    }
    public function getComentarios(Request $request){
        $input = $request->all();
        $id = $input["id"];
        $nota = Nota::find($id);
        $res = "";
        foreach($nota->comentarios as $comentario) {
            $res .= '<div class="row" style = "padding: 15px 0" >
                                  <div style = "padding: 0"  class="col-md-1" ><div class="field-circle" style = "float: right; background-image:url(/img/sitio/about.PNG);" ></div ></div >
                                  <div class="col-md-10" ><div class="form-control myfield" style="height:auto" ><b>'.$comentario->autor->name.'</b><p>'.$comentario->comentario.'</p></div ></div >
                                  <div style = "padding: 0"  class="col-md-1" ><div class="field-circle" style = "float: left;" ><i style = "padding: 10px 0" class="fas fa-times" ></i ></div ></div >
                              </div >';
        }
        return $res;
    }
    public function borrarComentarios(Request $request){
        $input = $request->all();
        $id = $input["id"];
        $nota = NotaComentario::find($id);
        $nota->delete();
    }
    public function megusta(Request $request){
        $input = $request->all();
        $userid = Auth::user()->id;
        $like = NotaLikes::where("nota_id",$input["id"])->where("user_id",$userid)->first();
        if($like){
            $like->delete();
            return [false];
        }
        else{
            NotaLikes::create(array(
                "nota_id"=>$input["id"],
                "user_id"=>$userid
            ));
            return [true];
        }
    }
    public function dologin(Request $request){
        $input = $request->all();
        $user = User::where("email",$input["email"])->where("password",$input["password"])->first();
        if($user){
            Auth::login($user);
        }
        return redirect("/");
    }

}