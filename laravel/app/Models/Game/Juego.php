<?php namespace App\Models\Game;

use App\Libraries\Repositories\GeneralRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Juego extends Model {

    public $table = "juegos";

    public $primaryKey = "id";

    protected $dates = [
        "created_at",
        "updated_at"
    ];

    public $timestamps = true;

    public $fillable = [
        "croupier",
        "inicial",
        "dobles",
        "saldo",
        "saldoinicial"
    ];

    public static $rules = [

    ];
    public function jugadas()
    {
        return $this->hasMany('App\Models\Game\Jugada', 'juego_id')->orderBy('id','desc');
    }
    public function apuestas()
    {
        return $this->hasMany('App\Models\Game\Apuesta', 'juego_id')->orderBy('id','desc');
    }
    public function apuestas2()
    {
        return $this->hasMany('App\Models\Game\Apuesta2', 'juego_id')->orderBy('id','desc');
    }
    public function getSalirAttribute(){
        $ganancia = $this->saldo-$this->saldoinicial;
        $uColor = Apuesta::where('tipo', "color")->where("juego_id",$this->id)->orderby("id","desc")->first();
        $uTipo = Apuesta::where('tipo', "tipo")->where("juego_id",$this->id)->orderby("id","desc")->first();
        $uMitad = Apuesta::where('tipo', "mitad")->where("juego_id",$this->id)->orderby("id","desc")->first();
        if($ganancia>=0&&$uColor&&($uColor->exitoso==1||($uColor->exitoso==null&&$uColor->factor==1))
            &&$uTipo&&($uTipo->exitoso==1||($uTipo->exitoso==null&&$uTipo->factor==1))
            &&$uMitad&&($uMitad->exitoso==1||($uMitad->exitoso==null&&$uMitad->factor==1))){
            return "si";
        }else{
            return "no";
        }
    }
    public function getJugadasCountAttribute(){
        return $this->jugadas->count();
    }
    public function getTiradasAttribute(){
        return Tirada::orderby("id","desc")->get();
    }
    public function getUltimasJugadasAttribute(){
        $cont = 10*2;
        return $this->jugadas->take($cont);
    }
    public function getStatsAttribute(){

        $id = $this->id;
        $tiradas = $this->tiradas;
        $totalJugadas = $this->jugadas_count;
        $tipos = ["color","tipo","mitad"];
        if($this->inicial>=10){
            $tipos = ["color"];
        }
        $cambios["color"] = ["rn","nr","rv","vr","nv","vn"];
        $cambios2["color"] = ["r|n","n|r","r|v","v|r","n|v","v|n"];
        $cambios["tipo"] = ["pi","ip","pv","vp","iv","vi"];
        $cambios2["tipo"] = ["p|i","i|p","p|v","v|p","i|v","v|i"];
        $cambios["mitad"] = ["cg","gc","cv","vc","gv","vg"];
        $cambios2["mitad"] = ["c|g","g|c","c|v","v|c","g|v","v|g"];
        $valores = ['r'=>'rojo','n'=>'negro','v'=>'verde','p'=>'par','i'=>'impar','c'=>'chico','g'=>'grande'];
        $contrario = ['rojo'=>'negro','negro'=>'rojo','verde'=>'todos','par'=>'impar','impar'=>'par','chico'=>'grande','grande'=>'chico'];
        $cadenas = ["color"=>'',"tipo"=>'',"mitad"=>''];
        $rachitas = ['rojo'=>0,'negro'=>0,'verde'=>0,'par'=>0,'impar'=>0,'chico'=>0,'grande'=>0];
        $predicciones = [];
        $apuesta = [];
        $posiciones = [];
        $distancias = [];
        $ganador = null;

        Racha::truncate();
        Racha2::truncate();
        Patron::truncate();

        GeneralRepository::sendToFront(["mensaje" => "=====>".count($tiradas)]);


        if(count($tiradas)>0) {
            foreach ($tiradas as $tirada) {
                foreach ($tipos as $tipo) {

                    $rachitas[$tirada->{$tipo}]++;
                    if ($tirada->{$tipo} != "verde") {
                        $rachitas[$contrario[$tirada->{$tipo}]] = 0;
                    } else {
                        $rachitas = ['rojo' => 0, 'negro' => 0, 'verde' => $rachitas["verde"], 'par' => 0, 'impar' => 0, 'chico' => 0, 'grande' => 0];
                    }
                    $cadenas[$tipo] .= substr($tirada->{$tipo}, 0, 1);
                }
                $ganador = $tirada;
            }

            $totalTiradas = count($tiradas);

            $tt = 0;
            foreach ($tipos as $tipo) {



                $predi = Prediccion::where(array(
                    "tipo" => $tipo,
                    "juego_id" => $id,
                    "exitoso" => null,
                    "valor" => $ganador->{$tipo}
                ))->first();

                if ($predi) {
                    $tt = $totalTiradas;
                    $predi->fill(array(
                        "exitoso" => 1
                    ))->save();
                }

                Prediccion::where(array(
                    "tipo" => $tipo,
                    "juego_id" => $id,
                    "exitoso" => null
                ))->update(array(
                    "exitoso" => 0
                ));

                Apuesta::where(array(
                    "tipo" => $tipo,
                    "juego_id" => $id,
                    "exitoso" => null,
                    "valor" => $ganador->{$tipo}
                ))->update(array(
                    "exitoso"=>1
                ));
                $aa = Apuesta2::where(array(
                    "tipo" => $tipo,
                    "juego_id" => $id,
                    "exitoso" => null,
                    "valor" => $ganador->{$tipo}
                ))->first();
                if ($aa) {
                    $aa->fill(array(
                        "exitoso" => 1
                    ))->save();
                        $this->fill(array(
                            "saldo" => DB::raw("saldo+" . $aa->cantidad)
                        ))->save();
                } else {
                    $xy = Apuesta2::where(array(
                        "tipo" => $tipo,
                        "juego_id" => $id,
                        "exitoso" => null
                    ))->first();
                    if ($xy) {
                            $this->fill(array(
                                "saldo" => DB::raw("saldo-" . $xy->cantidad)
                            ))->save();
                    }
                }
                Apuesta::where(array(
                    "tipo" => $tipo,
                    "juego_id" => $id,
                    "exitoso" => null
                ))->update(array(
                    "exitoso" => 0
                ));
                Apuesta2::where(array(
                    "tipo" => $tipo,
                    "juego_id" => $id,
                    "exitoso" => null
                ))->update(array(
                    "exitoso" => 0
                ));

                $ppredicciones = Prediccion::where("juego_id", $id)->where("tipo", $tipo)->select(
                    DB::raw("(SUM(exitoso)/COUNT(*))*100 as probabilidad"),
                    DB::raw("(SUM(exitoso)/(COUNT(*)+1))*100 as probabilidad2"),
                    DB::raw("SUM(exitoso) as exitoso"),
                    DB::raw("COUNT(*) as total"),
                )->first();
                $probabilidades[$tipo] = 0;
                $p1 = 0;
                if ($ppredicciones != null && $ppredicciones->probabilidad != null && $ppredicciones->total > 1) {
                    $probabilidades[$tipo] = $ppredicciones->probabilidad;
                    $p1 = $ppredicciones->probabilidad2;
                }

                //patron v2
                for ($i = 0; $i < strlen($cadenas[$tipo]); $i++) {
                    $caracter = $cadenas[$tipo][$i];
                    $y = strlen($cadenas[$tipo]) - $i + 1;
                    $posiciones[$caracter][] = $i;
                    $distancias[$caracter][] = $y;

                }
                //GeneralRepository::sendToFront(["mensaje"=>$tipo." -> ".json_encode($posiciones)]);
                foreach ($posiciones as $z => $posicion) {

                    $len = count($posicion);
                    for ($i = 0; $i < $len; $i++) {
                        $x = $posicion[$i];
                        for ($j = $i; $j < $len; $j++) {
                            $indice = $posicion[$j] - $x;
                            $rachaRow = Racha2::where("racha", $indice)->where("tipo", $tipo)->where("valor", $valores[$z])->first();
                            if ($rachaRow) {
                                $rachaRow->increment("conteo");
                            } else {
                                Racha2::create(array(
                                    "tipo" => $tipo,
                                    "racha" => $indice,
                                    "valor" => $valores[$z],
                                    "conteo" => 1
                                ));
                            }

                        }
                    }
                }
                $posiciones = [];
                $cadenas[$tipo] = str_replace($cambios[$tipo], $cambios2[$tipo], $cadenas[$tipo]);
                $patrones = explode("|", $cadenas[$tipo]);
                $totalPatrones = count($patrones);

                for ($i = 0; $i < $totalPatrones; $i++) {

                    /*
                    $p1 = $patrones[$i]?? "";
                    $p2 = $patrones[$i+1]?? "";
                    $texto = $p1.$p2;
                    $patronRow = Patron::where("patron",$texto)->where("tipo",$tipo)->first();
                    if($patronRow){
                        $patronRow->increment("conteo");
                    }
                    else{
                        Patron::create(array(
                            "tipo"=>$tipo,
                            "patron"=>$texto,
                            "conteo"=>1
                        ));
                    }
                    */

                    $index = substr($patrones[$i], 0, 1);
                    $valor = $valores[$index] ?? "";
                    $racha = strlen($patrones[$i]);
                    for ($j = 0; $j < $racha; $j++) {
                        $rachaRow = Racha::where("racha", $j)->where("tipo", $tipo)->where("valor", $valor)->first();

                        if ($rachaRow) {
                            $rachaRow->increment("conteo");
                        } else {
                            Racha::create(array(
                                "tipo" => $tipo,
                                "racha" => $j,
                                "valor" => $valor,
                                "conteo" => 1
                            ));
                        }
                    }
                }

                //2.predicciones Racha son Rachas, Racha2 son patrones

                $ultima = $patrones[$totalPatrones - 1];
                $index = substr($ultima, 0, 1);
                $ultimovalor = $valores[$index] ?? "";
                $rachaultimovalor = $rachitas[$ultimovalor] ?? "";

                $racha1 = Racha::where([
                    "tipo" => $tipo,
                    "valor" => $ultimovalor,
                    "racha" => $rachaultimovalor
                ])->first();
                $valor1 = '';
                $r1 = 0;
                if ($racha1) {
                    $valor1 = $racha1->valor;
                    $r1 = $racha1->conteo;
                }

                $racha2 = null;
                $valor2 = '';
                $r2 = 0;
                $contra = "";

                if ($ultimovalor != "verde") {
                    $contra = $contrario[$ultimovalor] ?? "";
                    $rachacontra = $rachitas[$contra] ?? 0;
                    $racha2 = Racha::where([
                        "tipo" => $tipo,
                        "valor" => $contra,
                        "racha" => $rachacontra
                    ])->first();
                }

                if ($racha2) {
                    $valor2 = $racha2->valor;
                    $r2 = $racha2->conteo;
                }

                $racha3 = Racha2::whereIn("racha", $distancias[$index])
                    ->where("valor", $ultimovalor)
                    ->where("tipo", $tipo)
                    ->orderby("conteo", "desc")->first();

                $valor3 = '';
                $r3 = 0;
                if ($racha3) {
                    $valor3 = $racha3->valor;
                    $r3 = $racha3->conteo;
                }

                $min = 20;
                $hayprediccion = 0;
                if ($totalTiradas >= $tt) {
                    $p = null;
                    $div1 = round(($r1 / $totalTiradas) * 100);
                    $div2 = round(($r2 / $totalTiradas) * 100);
                    $div3 = round(($r3 / $totalTiradas) * 100);

                    if ($r1 > $r2 && $r1 > $r3 && $r1 > 2 && $div1 > $min) {
                        $valorPrediccion = $valor1;
                        $rachaPrediccion = $r1;
                        $tipoPrediccion = "Racha";
                        /**/
                        $predicciones[$tipo] = $valorPrediccion;
                        $apuesta = $this->setPredicciones($id,$tipo,$valorPrediccion,$rachaPrediccion,$tipoPrediccion,$totalTiradas,$p1,$apuesta);
                        $hayprediccion = 1;
                        /**/
                    }
                    else if ($r2 > $r1 && $r2 > $r3 && $r2 > 2 && $div2 > $min) {
                        $valorPrediccion = $valor2;
                        $rachaPrediccion = $r2;
                        $tipoPrediccion = "Racha";
                        /**/
                        $apuesta = $this->setPredicciones($id,$tipo,$valorPrediccion,$rachaPrediccion,$tipoPrediccion,$totalTiradas,$p1,$apuesta);
                        $hayprediccion = 1;
                        /**/
                    }
                    else if ($r3 > $r1 && $r3 > $r2 && $r3 > 2 && $div3 > $min) {
                        $valorPrediccion = $valor3;
                        $rachaPrediccion = $r3;
                        $tipoPrediccion = "Patron";
                        /**/
                        $apuesta = $this->setPredicciones($id,$tipo,$valorPrediccion,$rachaPrediccion,$tipoPrediccion,$totalTiradas,$p1,$apuesta);
                        $hayprediccion = 1;
                        /**/
                    }
                    else if ((($r1 == $r2 && $valor1 == $valor2) || ($r1 == $r3 && $valor1 == $valor3)) && $r1 > 2 && $div1 > $min) {
                        $valorPrediccion = $valor1;
                        $rachaPrediccion = $r1;
                        $tipoPrediccion = "Racha";
                        /**/
                        $apuesta = $this->setPredicciones($id,$tipo,$valorPrediccion,$rachaPrediccion,$tipoPrediccion,$totalTiradas,$p1,$apuesta);
                        $hayprediccion = 1;
                        /**/
                    }
                    else if ((($r2 == $r1 && $valor2 == $valor1) || ($r2 == $r3 && $valor2 == $valor3)) && $r2 > 2 && $div2 > $min) {
                        $valorPrediccion = $valor2;
                        $rachaPrediccion = $r2;
                        $tipoPrediccion = "Racha";
                        /**/
                        $apuesta = $this->setPredicciones($id,$tipo,$valorPrediccion,$rachaPrediccion,$tipoPrediccion,$totalTiradas,$p1,$apuesta);
                        $hayprediccion = 1;
                        /**/
                    }
                    else if ((($r3 == $r1 && $valor3 == $valor1) || ($r3 == $r2 && $valor3 == $valor2)) && $r3 > 2 && $div3 > $min) {
                        $valorPrediccion = $valor3;
                        $rachaPrediccion = $r3;
                        $tipoPrediccion = "Patron";
                        /**/
                        $apuesta = $this->setPredicciones($id,$tipo,$valorPrediccion,$rachaPrediccion,$tipoPrediccion,$totalTiradas,$p1,$apuesta);
                        $hayprediccion = 1;
                        /**/
                    }



                    /*if($tipo=="mitad") {
                        GeneralRepository::sendToFront(["mensaje" => "---------------------".$totalTiradas."->".$p1]);
                        GeneralRepository::sendToFront(["mensaje" => json_encode($racha1)]);
                        GeneralRepository::sendToFront(["mensaje" => json_encode($racha2)]);
                        GeneralRepository::sendToFront(["mensaje" => json_encode($racha3)]);
                    }*/
                    /*if($hayprediccion == 0){
                        Prediccion::where("juego_id",$id)->where("tipo",$tipo)->whereNotNull("exitoso")->delete();

                    }*/
                }
            }
            /*foreach ($apuesta as $tipo => $a) {
                $factor = Apuesta::factor($tipo, $id);

                $ap = Apuesta::where([
                    "juego_id" => $id,
                    "tipo" => $tipo,
                    "prediccion_id" => $totalJugadas,
                    "valor" => $a["valor"],
                    "probabilidad" => $a["probabilidad"]
                ])->first();
                if (!$ap) {
                    Apuesta::create([
                        "juego_id" => $id,
                        "tipo" => $tipo,
                        "prediccion_id" => $totalJugadas,
                        "valor" => $a["valor"],
                        "probabilidad" => $a["probabilidad"],
                        "exitoso" => null,
                        "factor" => $factor
                    ]);
                }

            }*/
        }
    }
    function setPredicciones($id,$tipo,$valorPrediccion,$rachaPrediccion,$tipoPrediccion,$totalTiradas,$p1,$apuesta){
        /**/
        $contrario = ['rojo'=>'negro','negro'=>'rojo','verde'=>'todos','par'=>'impar','impar'=>'par','chico'=>'grande','grande'=>'chico'];
        $p0 = Prediccion::select(DB::raw("IFNULL(COUNT(IF(exitoso = '1', 1, NULL)) - COUNT(IF(exitoso = '0', 1, NULL)),0) as conteo"))->where("juego_id",$id)->where("tipo",$tipo)->first();
        $p0 = isset($p0)? $p0->conteo:0;

        $porcentajePrediccion = round(($rachaPrediccion / $totalTiradas) * 100);
        $hacerApuesta = 0;
        /*$p = Prediccion::where([
            "juego_id" => $id,
            "tipo" => $tipo,
            "valor" => $valorPrediccion,
            "probabilidad" => $rachaPrediccion,
            "prediccion" => $tipoPrediccion . " " . $rachaPrediccion . "/" . $totalTiradas . " = " . $porcentajePrediccion . "%"
        ])->first();
        if (!$p) {*/
            $p = Prediccion::create([
                "juego_id" => $id,
                "tipo" => $tipo,
                "valor" => $valorPrediccion,
                "probabilidad" => $rachaPrediccion,
                "prediccion" => $tipoPrediccion . " " . $rachaPrediccion . "/" . $totalTiradas . " = " . $porcentajePrediccion . "%",
                "exitoso" => null
            ]);
        //}
        $apuesta[$tipo]["valor"] = $contrario[$valorPrediccion];
        $apuesta[$tipo]["probabilidad"] = 100 - $p1;
        $hacerApuesta = 1;
        
        /*
        if ($p0==0 && $p1>0 && $rachaPrediccion > 2) {
            $apuesta[$tipo]["valor"] = $p1 < 40 ? $contrario[$valorPrediccion] : $valorPrediccion;
            $apuesta[$tipo]["probabilidad"] = $p1 < 40 ? 100 - $p1 : $p1;
            $hacerApuesta = 1;
        }
        else if($p0>0){
            $apuesta[$tipo]["valor"] = $valorPrediccion;
            $apuesta[$tipo]["probabilidad"] = $p1;
            $hacerApuesta = 1;
        }
        else if($p0 < 0){
            $apuesta[$tipo]["valor"] = $contrario[$valorPrediccion];
            $apuesta[$tipo]["probabilidad"] = 100 - $p1;
            $hacerApuesta = 1;
        }
        */
        if($hacerApuesta == 1) {
            $factor = Apuesta2::factor($tipo, $id);

            /*$ap = Apuesta::where([
                "juego_id" => $id,
                "tipo" => $tipo,
                "prediccion_id" => $totalTiradas,
                "valor" => $apuesta[$tipo]["valor"],
                "probabilidad" => $apuesta[$tipo]["probabilidad"]
            ])->first();
            if (!$ap) {*/
            Apuesta::create([
                "juego_id" => $id,
                "tipo" => $tipo,
                "prediccion_id" => $totalTiradas,
                "valor" => $apuesta[$tipo]["valor"],
                "probabilidad" => $apuesta[$tipo]["probabilidad"],
                "exitoso" => null,
                "factor" => $factor
            ]);
            //}

        }

        /*if($tipo=="mitad") {
            GeneralRepository::sendToFront(["mensaje" => "***************".$totalTiradas."->".$p1]);
            GeneralRepository::sendToFront(["mensaje" => "PREDICCION: ".json_encode($p)]);
            GeneralRepository::sendToFront(["mensaje" => $apuesta[$tipo]["valor"]?? ""]);
        }*/
        return $apuesta;
    }
    public function getLoadJugadasAttribute(){
        $jugadas = $this->ultimas_jugadas;
        Tirada::truncate();
        foreach ($jugadas as $jugada){
            Tirada::create([
                'numero' => $jugada->numero,
                'color' => $jugada->color,
                'tipo' => $jugada->tipo,
                'mitad' => $jugada->mitad,
                'jugada_id' => $jugada->id
            ]);
        }
    }
    public function getLoadApuestasAttribute(){
        $apuestas = Apuesta::where("juego_id",$this->id)->whereNull("exitoso")->orderby("tipo","asc")->get();

        foreach ($apuestas as $apuesta){
            $last = Apuesta::where("juego_id",$this->id)->whereNotNull("exitoso")->where("tipo",$apuesta->tipo)
                ->orderby("id","desc")->first();
            if($last&&$last->exitoso==0){
                $cant = $last->cantidad;

            }
            else{
                $cant = $this->inicial;
            }
            $apuesta->fill(array(
                "cantidad"=>$cant
            ))->save();
        }
        return $apuestas;
    }
    public function getLoadPrediccionesAttribute(){
        $apuestas = Prediccion::where("juego_id",$this->id)->whereNull("exitoso")->orderby("probabilidad","desc")->get();
        return $apuestas;
    }

}
