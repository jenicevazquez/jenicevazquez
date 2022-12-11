<?php


namespace App\Http\Controllers;

use App\Libraries\Repositories\GeneralRepository;
use App\Models\Game\Apuesta;
use App\Models\Game\Apuesta2;
use App\Models\Game\Jugada;
use App\Models\Game\Prediccion;
use App\Models\Game\Tablero;
use App\Models\Game\Tirada;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\Game\Juego;

class GameController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $numeros = [];
        return view('game')->with("numeros",$numeros);
    }
    function destroy($id){
        $juego = Juego::find($id);
        $juego->jugadas()->delete();
        $juego->apuestas()->delete();
        $juego->delete();
    }
    function clean($id){
        $juego = Juego::find($id);
        $juego->jugadas()->delete();
        $juego->apuestas()->delete();
        $juego->apuestas2()->delete();
    }

    function getProbabilidadRacha($tipo,$racha,$mesa="EURO"){
        $t = $racha+1;
        $num = $mesa=="AME"? 38:37;
        $tipo = $tipo!="verde"? 18:($mesa=="AME"? 2:1);
        return pow($tipo/$num,$t)*100;
    }
    function nuevoJuego(Request $request){
        $input = $request->all();
        $input["saldoinicial"] = $input["saldo"];
        return Juego::create($input);
    }
    function demoJuego(Request $request){
        $input = $request->all();
        $juego = Juego::find($input["id"]);
        $juego->jugadas()->delete();
        $juego->apuestas()->delete();
        $path = '/home/u444303969/domains/jenicevazquez.com/public_html/history.html';
        $content = file_get_contents($path);
        $content = str_replace('">','">|',$content);
        $content = strip_tags($content);
        $content = trim(preg_replace('/[ |]+/', '|', $content));
        $content = trim($content, "|");
        $numeros = explode("|",$content);
        $numeros = array_reverse($numeros);
        //$numeros = array_slice($numeros, 0, 45);
        return $numeros;
    }
    function getJuegos(Request $request){
        $q = $request->all();
        $registros = Juego::paginate(15);
        return [
            view("game.datapanelJuegos")->with("registros",$registros)->with("q",$q)->render(),
            view("paginado")->with("registros",$registros)->render()
        ];
    }
    function getPredicciones(Request $request){
        $q = $request->all();
        $registros = Prediccion::orderby("tipo","asc")->orderby("id","desc")->get();
        return [
            view("game.datapanelPredicciones")->with("registros",$registros)->with("q",$q)->render()
        ];
    }
    function insertTirada(Request $request){
        $input = $request->all();
        $num = $input["numero"];
        $id = $input["idJuego"];
        //if($num>0) {
            $tirada = Tablero::getnumero($num);
            Jugada::addJugada($tirada, $id);
        //}
        //$juego = Juego::where("id",$id)->first();
        //$juego->estadisticas = $juego->stats;
        //return $juego;
    }
    function deleteTirada(Request $request){
        $input = $request->all();
        $id = $input["idTirada"];
        $tirada = Tirada::find($id);
        Jugada::where("id",$tirada->jugada_id)->delete();

    }
    function loadJuego(Request $request){
        $input = $request->all();
        $id = $input["id"];
        $juego = Juego::where("id",$id)->first();
        $juego->load_jugadas;
        $juego->estadisticas = $juego->stats;
        $juego = Juego::where("id",$id)->first();
        $juego->tiros = $juego->tiradas;
        $juego->salida = $juego->salir;
        $juego->apuestas = $juego->load_apuestas;
        $juego->predicciones = $juego->load_predicciones;

        $predicciones[] = Prediccion::select(DB::raw("IFNULL(COUNT(IF(exitoso = '1', 1, NULL)) - COUNT(IF(exitoso = '0', 1, NULL)),0) as conteo"))->where("juego_id",$id)->where("tipo","color")->first();
        $predicciones[] = Prediccion::select(DB::raw("IFNULL(COUNT(IF(exitoso = '1', 1, NULL)) - COUNT(IF(exitoso = '0', 1, NULL)),0) as conteo"))->where("juego_id",$id)->where("tipo","mitad")->first();
        $predicciones[] = Prediccion::select(DB::raw("IFNULL(COUNT(IF(exitoso = '1', 1, NULL)) - COUNT(IF(exitoso = '0', 1, NULL)),0) as conteo"))->where("juego_id",$id)->where("tipo","tipo")->first();
        $juego->xpredicciones = $predicciones;

        $apuestas[] = Apuesta::select(DB::raw("IFNULL(COUNT(IF(exitoso = '1', 1, NULL)) - COUNT(IF(exitoso = '0', 1, NULL)),0) as conteo"))->where("juego_id",$id)->where("tipo","color")->first();
        $apuestas[] = Apuesta::select(DB::raw("IFNULL(COUNT(IF(exitoso = '1', 1, NULL)) - COUNT(IF(exitoso = '0', 1, NULL)),0) as conteo"))->where("juego_id",$id)->where("tipo","mitad")->first();
        $apuestas[] = Apuesta::select(DB::raw("IFNULL(COUNT(IF(exitoso = '1', 1, NULL)) - COUNT(IF(exitoso = '0', 1, NULL)),0) as conteo"))->where("juego_id",$id)->where("tipo","tipo")->first();
        $juego->xapuestas = $apuestas;

        $apuestas2[] = Apuesta2::select(DB::raw("IFNULL(COUNT(IF(exitoso = '1', 1, NULL)) - COUNT(IF(exitoso = '0', 1, NULL)),0) as conteo"))->where("juego_id",$id)->where("tipo","color")->first();
        $apuestas2[] = Apuesta2::select(DB::raw("IFNULL(COUNT(IF(exitoso = '1', 1, NULL)) - COUNT(IF(exitoso = '0', 1, NULL)),0) as conteo"))->where("juego_id",$id)->where("tipo","mitad")->first();
        $apuestas2[] = Apuesta2::select(DB::raw("IFNULL(COUNT(IF(exitoso = '1', 1, NULL)) - COUNT(IF(exitoso = '0', 1, NULL)),0) as conteo"))->where("juego_id",$id)->where("tipo","tipo")->first();
        $juego->xapuestas2 = $apuestas2;

        $factores[] = Apuesta2::factor("color", $id);
        $factores[] = Apuesta2::factor("mitad", $id);
        $factores[] = Apuesta2::factor("tipo", $id);
        $juego->factores = $factores;

        return $juego;
    }
    function hacerApuesta(Request $request){
        $input = $request->all();
        $id = $input["id"];
        $juego = Juego::find($id);
        if(isset($input["scolor"])&&$input["scolor"]!=""){
            $tipo = "color";
            $factor = Apuesta2::factor($tipo, $id);
            Apuesta2::create([
                "juego_id" => $input["id"],
                "tipo" => "color",
                "valor" => $input["scolor"],
                "exitoso" => null,
                "factor" => $factor
            ]);
        }
        if(isset($input["stipo"])&&$input["stipo"]!=""){
            $tipo = "tipo";
            $factor = Apuesta2::factor($tipo, $id);
            Apuesta2::create([
                "juego_id" => $input["id"],
                "tipo" => "tipo",
                "valor" => $input["stipo"],
                "exitoso" => null,
                "factor" => $factor
            ]);
        }
        if(isset($input["smitad"])&&$input["smitad"]!=""){
            $tipo = "mitad";
            $factor = Apuesta2::factor($tipo, $id);
            Apuesta2::create([
                "juego_id" => $input["id"],
                "tipo" => "mitad",
                "valor" => $input["smitad"],
                "exitoso" => null,
                "factor" => $factor
            ]);
        }
        $apuestas = Apuesta2::where("juego_id",$id)->whereNull("exitoso")->orderby("tipo","asc")->get();
        foreach ($apuestas as $apuesta){
            $last = Apuesta2::where("juego_id",$id)->whereNotNull("exitoso")->where("tipo",$apuesta->tipo)
                ->orderby("id","desc")->first();
            if($last&&$last->exitoso==0){
                $cant = $last->factor*$juego->inicial;
            }
            else{
                $cant = $juego->inicial;
            }
            $apuesta->fill(array(
                "cantidad"=>$cant
            ))->save();
        }

    }

}