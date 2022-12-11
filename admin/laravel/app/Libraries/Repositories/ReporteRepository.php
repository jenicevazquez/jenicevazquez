<?php

namespace App\Libraries\Repositories;
use App\Model\Producto;
use App\Model\VentaItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ReporteRepository
{
    public function getReporteUtilidades($input){
        $suc = Session::get("sucursal_id");
        $query = VentaItem::leftjoin("ventas","ventas.id","=","ventaitems.venta_id")
            ->leftjoin("productos","productos.id","=","ventaitems.producto_id")
            ->where("ventas.sucursal_id",$suc)->where("ventas.estatus","1")
            ->groupby("productos.clave")->groupby("productos.descripcion")
            ->whereRaw("(ventas.fecha>='".$input["fechaini"]."' and ventas.fecha<='".$input["fechafin"]."')");
        if($input["confechas"]){
            $query->select(
                "productos.clave as Clave",
                "productos.descripcion as Producto",
                DB::raw("SUM(ventaitems.cantidad) as Cantidad"),
                DB::raw("SUM(productos.preciocompra)/SUM(productos.factor) as 'Costo Unitario'"),
                DB::raw("SUM(ventaitems.cantidad)*(SUM(productos.preciocompra)/SUM(productos.factor)) as 'Costo Total'"),
                DB::raw("SUM(ventaitems.importe) as Venta"),
                DB::raw("(SUM(ventaitems.importe))-(SUM(ventaitems.cantidad)*(SUM(productos.preciocompra)/SUM(productos.factor))) as Utilidad"),
                "ventas.fecha as Fecha"
            )
            ->groupby("ventas.fecha");
        }else{
            $query->select(
                "productos.clave as Clave",
                "productos.descripcion as Producto",
                DB::raw("SUM(ventaitems.cantidad) as Cantidad"),
                DB::raw("SUM(productos.preciocompra)/SUM(productos.factor) as 'Costo Unitario'"),
                DB::raw("SUM(ventaitems.cantidad)*(SUM(productos.preciocompra)/SUM(productos.factor)) as 'Costo Total'"),
                DB::raw("SUM(ventaitems.importe) as Venta"),
                DB::raw("(SUM(ventaitems.importe))-(SUM(ventaitems.cantidad)*(SUM(productos.preciocompra)/SUM(productos.factor))) as Utilidad")
            );
        }

        $ventas = $query->get();
        return $ventas;
    }
    public function getReporteInventario($input){
        $suc = Session::get("sucursal_id");
        $query = Producto::select(
                "productos.clave as Clave",
                "productos.descripcion as Producto",
                DB::raw("(SELECT TOP 1 producto_sucursal.stock FROM producto_sucursal WHERE producto_sucursal.producto_id=productos.id and producto_sucursal.sucursal_id=".$suc.") as Cantidad"),
                DB::raw("(SELECT TOP 1 precio FROM precios WHERE productos_id=productos.id and nombre='precio1')*(SELECT TOP 1 producto_sucursal.stock FROM producto_sucursal WHERE producto_sucursal.producto_id=productos.id and producto_sucursal.sucursal_id=".$suc.") as Precio"),
                DB::raw("(SELECT TOP 1 precio FROM precios WHERE productos_id=productos.id and nombre='precio2')*(SELECT TOP 1 producto_sucursal.stock FROM producto_sucursal WHERE producto_sucursal.producto_id=productos.id and producto_sucursal.sucursal_id=".$suc.") as Especial"),
                DB::raw("(SELECT TOP 1 precio FROM precios WHERE productos_id=productos.id and nombre='precio3')*(SELECT TOP 1 producto_sucursal.stock FROM producto_sucursal WHERE producto_sucursal.producto_id=productos.id and producto_sucursal.sucursal_id=".$suc.") as Mayoreo")
            );
        $ventas = $query->get();
        return $ventas;
    }
}