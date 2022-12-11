<?php

namespace App\Libraries\Repositories;


use App\Models\Indirecto;
use App\Models\materiales;
use App\Models\Servicio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;

class ReporteRepository
{
  public function getReporteMateriaPrima($input){
    $datos = DB::table('materiales')->join('proveedores', 'materiales.id_proveedor', '=', 'proveedores.id')
      ->select(
        'materiales.numero as Numero',
        'proveedores.nombre as Proveedor',
        'materiales.nombre as Nombre',
        'materiales.unidad as Unidad',
        'materiales.tamano as Medida',
        'materiales.color as Color',
        'materiales.cantidad as Cantidad',
        'materiales.precio_venta as PUnitario',
        DB::raw('materiales.cantidad*materiales.precio_venta as Total')
      );
    $totales = DB::table('materiales')->join('proveedores', 'materiales.id_proveedor', '=', 'proveedores.id')
      ->select(
        DB::raw('"" as Numero'),
        DB::raw('"" as Proveedor'),
        DB::raw('"TOTAL" as Nombre'),
        DB::raw('"" as Unidad'),
        DB::raw('"" as Medida'),
        DB::raw('"" as Color'),
        DB::raw('"" as Cantidad'),
        DB::raw('"" as PUnitario'),
        DB::raw('SUM(materiales.cantidad*materiales.precio_venta) as Total')
      );
    return $datos->union($totales)->get();
  }
  public function getReporteProduccion($input){
    $indirecto = GeneralRepository::empresa()->indirecto;
    $factor = ($indirecto/100)+1;
    $result=DB::table('ordenes')
      ->leftJoin('mano_productos','mano_productos.id_orden','=','ordenes.id')
      ->leftjoin('productos', 'ordenes.id_producto', '=', 'productos.id')
      ->leftjoin('mano_obra','mano_obra.id','=','mano_productos.id_mano')
      ->select(
        'ordenes.created_at as Fecha',
        'mano_obra.nombre as Empleado',
        'ordenes.id as Orden',
        'productos.codigo as Codigo',
        'productos.nombre as Producto',
        'mano_productos.cantidad as Cantidad',
        DB::raw('(productos.costo_directo*'.$factor.') as Costo'),
        'mano_productos.produccion as Produccion',
        'mano_productos.sinpulir as SinPulir',
        'mano_productos.listo as Listo',
        'ordenes.estatus as Status',
        DB::raw('(productos.costo_directo*'.$factor.')*mano_productos.cantidad as Total')
      )
      ->whereRaw('(ordenes.created_at>="'.$input["fechaini"].'" and ordenes.created_at<="'.$input["fechafin"].'")');
    $totales=DB::table('ordenes')
      ->leftJoin('mano_productos','mano_productos.id_orden','=','ordenes.id')
      ->leftjoin('productos', 'ordenes.id_producto', '=', 'productos.id')
      ->select(
        DB::raw('"" as Fecha'),
        DB::raw('"" as Empleado'),
        DB::raw('"" as Orden'),
        DB::raw('"" as Codigo'),
        DB::raw('"TOTAL" as Producto'),
        DB::raw('"" as Cantidad'),
        DB::raw('"" as Costo'),
        DB::raw('"" as Produccion'),
        DB::raw('"" as SinPulir'),
        DB::raw('"" as Listo'),
        DB::raw('"" as Status'),
        DB::raw('SUM((productos.costo_directo*'.$factor.')*mano_productos.cantidad) as Total')
      )
      ->whereRaw('(ordenes.created_at>="'.$input["fechaini"].'" and ordenes.created_at<="'.$input["fechafin"].'")');

    //dd($result->get());
    return $result->union($totales)->get();
  }
  public function getReporteCostos($input){


    $directs=DB::table('productos_directos')
      ->leftJoin('productos','productos.id', '=', 'productos_directos.id_producto')
      ->leftJoin('directos','directos.id','=','productos_directos.id_directo')
      ->leftjoin('entradasStock', 'entradasStock.id_producto', '=', 'productos.id')
      ->select(
        'directos.nombre as concepto',
        DB::raw('(entradasStock.cantidad*productos_directos.costo) as valor')
      )
      ->whereRaw('(entradasStock.fecha>="'.$input["fechaini"].'" and entradasStock.fecha<="'.$input["fechafin"].'")');

    $mano=DB::table('entradasStock')
      ->leftjoin('productos', 'entradasStock.id_producto', '=', 'productos.id')
      ->select(
        DB::raw('"Mano de obra" as concepto'),
        DB::raw('SUM(entradasStock.cantidad*productos.costo_mano) as valor')
      )
      ->whereRaw('(entradasStock.fecha>="'.$input["fechaini"].'" and entradasStock.fecha<="'.$input["fechafin"].'")');
    $materiales = DB::table('entradasStock')
      ->leftjoin('productos', 'entradasStock.id_producto', '=', 'productos.id')
      ->leftJoin('materiales_productos','productos.id','=','materiales_productos.id_producto')
      ->leftJoin('materiales','materiales.id','=','materiales_productos.id_material')
      ->select(
        DB::raw('"Materiales" as concepto'),
        DB::raw('SUM(entradasStock.cantidad*(materiales_productos.cantidad*materiales.precio_venta)) as valor'));
    $directos = $directs->union($mano)->union($materiales)->get();
    $total = 0;
    foreach($directos as $directo){
      $total+=$directo->valor;
    }
    $indipercent = GeneralRepository::empresa()->indirecto;
    $indi = $total*($indipercent/100);
    $indirectos = DB::table("indirectos")->select(
      "indirectos.nombre as concepto",
      DB::raw($indi."*(indirectos.porcentaje/100) as valor")
    )->get();

    return [$directos,$indirectos];
  }
  public function getReporteCostos2($input){

    $productos = DB::table('entradasStock')
      ->leftjoin('productos', 'entradasStock.id_producto', '=', 'productos.id')
      ->select('entradasStock.cantidad','productos.codigo','productos.nombre','productos.descripcion','productos.costo_mano',
        'productos.costo_directo','productos.costo_indirecto','productos.id')
      ->whereRaw('(entradasStock.fecha>="'.$input["fechaini"].'" and entradasStock.fecha<="'.$input["fechafin"].'") and entradasStock.cantidad>0')->get();
    foreach($productos as $producto){
      $directos = DB::table("productos_directos")->leftJoin("directos","directos.id","=","productos_directos.id_directo")
        ->select("directos.nombre as directo","productos_directos.costo")
        ->where("productos_directos.id_producto",$producto->id)->get();
      $producto->directos = $directos;
      $material = DB::table("materiales_productos")->leftJoin("materiales","materiales.id","=","materiales_productos.id_material")
        ->select(
          DB::raw("SUM(materiales_productos.cantidad*materiales.precio_venta) as sub")
        )
        ->where("materiales_productos.id_producto",$producto->id)->pluck("sub");
      $producto->material = $material;
    }

    $indirectos = DB::table("indirectos")->get();

    return [$productos,$indirectos];
  }
  public function getReporteNomina($input){
    $result=DB::table('nominas')
      ->leftJoin('ordenes','nominas.id_orden','=','ordenes.id')
      ->leftjoin('productos', 'ordenes.id_producto', '=', 'productos.id')
      ->leftjoin('mano_obra','mano_obra.id','=','nominas.id_mano')
      ->select(
        'nominas.id',
        'ordenes.id as Orden',
        'productos.codigo as Codigo',
        'nominas.cantidad as Cantidad',
        'productos.nombre as Produccion',
        'mano_obra.nombre as Empleado',
        DB::raw('DATE_FORMAT(nominas.created_at,"%d %M") as Fecha'),
        'productos.costo_mano as Unidad',
        DB::raw('productos.costo_mano*nominas.cantidad as Total')
      );
    if($input["mano"]!=0){
      $result->where("nominas.id_mano",$input["mano"]);
    }
    $result->whereRaw('((nominas.created_at<="'.$input["fechafin"].'" and nominas.status="PENDIENTE") or (nominas.created_at>="'.$input["fechaini"].'" and nominas.created_at<="'.$input["fechafin"].'"))');
    //dd($result->toSql());
    $nominas = $result->get();
    foreach($nominas as $nomina){
      $pagos = DB::table('abonosNomina')->where("id_nomina",$nomina->id)
        ->select(
          'abonosNomina.cantidad as Anticipo',
          DB::raw('DATE_FORMAT(abonosNomina.created_at,"%d %M") as Fecha3'),
          'abonosNomina.recibo as Concepto'
        )
        ->get();
      $nomina->pagos = $pagos;
    }
    //dd($nominas);
     // $result->groupBy(DB::raw('nominas.created_at WITH ROLLUP'));
    //dd($result->get());*/





    return $nominas;
  }

  public function getReporteInventario(){
    $indirecto = GeneralRepository::empresa()->indirecto;
    $factor = ($indirecto/100)+1;
    $total = 0;
    $query = DB::table("productos")
      ->where("stock",">",0)
      ->select(
        "productos.codigo as Codigo",
        "productos.nombre as Nombre",
        "productos.stock as Cantidad",
        DB::raw('(productos.costo_directo*'.$factor.') as Costo'),
        DB::raw('(productos.costo_directo*'.$factor.')*productos.stock as Total')
      );
    foreach($query->get() as $r){
      $total += $r->Total;
    }
    $totales = DB::table("productos")
      ->where("stock",">",0)
      ->select(
        DB::raw("'' as Codigo"),
        DB::raw("'TOTAL' as Nombre"),
        DB::raw("'' as Cantidad"),
        DB::raw("'' as Costo"),
        DB::raw("'".$total."' as Total")
      );

    $todos = $query->union($totales)->get();
    return $todos;
  }
  public function SetProduccionCost(){
    $productos = DB::table('productos')->get();
    foreach($productos as $producto){
      $directo = DB::table("productos_directos")->leftJoin("directos","directos.id","=","productos_directos.id_directo")
        ->select(DB::raw("SUM(productos_directos.costo) AS directo"))
        ->where("productos_directos.id_producto",$producto->id)->pluck("directo");

      $material = DB::table("materiales_productos")->leftJoin("materiales","materiales.id","=","materiales_productos.id_material")
        ->select(
          DB::raw("SUM(materiales_productos.cantidad*materiales.precio_venta) as sub")
        )
        ->where("materiales_productos.id_producto",$producto->id)->pluck("sub");
      $costo_directo = $directo+$material+$producto->costo_mano;
      DB::table('productos')->where("id",$producto->id)->update(array(
        "costo_directo"=>$costo_directo
      ));
    }
  }

}