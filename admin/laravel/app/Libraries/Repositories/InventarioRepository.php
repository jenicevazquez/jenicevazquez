<?php

namespace App\Libraries\Repositories;
use App\Model\Inventario;
use App\Model\Producto;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class InventarioRepository
{
    public function getInventario($input){
        $perpage = 20;
        $page = $input["page"];
        $start = ($page-1)*$perpage;
        $suc = Session::get("sucursal_id");
        $subquery = "SELECT TOP 1 producto_sucursal.stock FROM producto_sucursal WHERE producto_id=productos.id and producto_sucursal.etapa=0 and sucursal_id=" . $suc;
        $query = Inventario::withoutglobalscope('producto')->select(
                    "productos.id",
                    "productos.clave",
                    "productos.clave2 as numparte",
                    "productos.descripcion",
                    "productos.factor",
                    "producto_sucursal.stock",
                    DB::raw("(SELECT categoria from categorias where productos.id = categorias_id) as categoria"),
                    DB::raw("(SELECT marca from marcas where productos.id = marca_id) as marca"),
                    DB::raw("(SELECT proveedor from proveedores where productos.id = proveedor_id) as proveedor"),
                    DB::raw("(SELECT nombre from localizaciones where producto_sucursal.localizacion_id = localizaciones.id) as localizacion"),
                    DB::raw("(SELECT nombre from unidades where unidades.id = productos.unidadcompra) as unidadllegada"),
                    DB::raw("(SELECT nombre from unidades where unidades.id = productos.unidadventa) as unidaduso")
                )->rightjoin("productos","productos.id","=",DB::raw("producto_sucursal.producto_id and producto_sucursal.etapa=0"))
                ->whereRaw("producto_sucursal.sucursal_id='$suc' AND producto_sucursal.stock>0");


        $queryCount = Producto::select("*")
            ->leftjoin("producto_sucursal","productos.id","=","producto_sucursal.producto_id")
            ->whereRaw("producto_sucursal.sucursal_id='$suc'");
        if($input["clave"]!==""){
            $query->where("clave",$input["clave"])->orWhere("clave2",$input["clave"]);
            $queryCount->where("clave",$input["clave"])->orWhere("clave2",$input["clave"]);
        }
        if(isset($input["categoria"]) && $input["categoria"]!==""){
            $query->whereRaw("(SELECT categoria from categorias where categorias.id = categorias_id) like '%".$input["categoria"]."%'");
            $queryCount->whereRaw("(SELECT categoria from categorias where categorias.id = categorias_id) like '%".$input["categoria"]."%'");
        }
        if($input["marca"]!==""){
            $query->whereRaw("(SELECT marca from marcas where marcas.id = marca_id) like '%".$input["marca"]."%'");
            $queryCount->whereRaw("(SELECT marca from marcas where marcas.id = marca_id) like '%".$input["marca"]."%'");
        }
        if($input["descripcion"]!==""){
            $query->whereRaw("descripcion like '%".$input["descripcion"]."%'");
            $queryCount->whereRaw("descripcion like '%".$input["descripcion"]."%'");
        }
        if($input["proveedor"]!==""){
            $query->whereRaw("(SELECT proveedor from proveedores where proveedores.id = proveedor_id) like '%".$input["proveedor"]."%'");
            $queryCount->whereRaw("(SELECT proveedor from proveedores where proveedores.id = proveedor_id) like '%".$input["proveedor"]."%'");
        }
        if (isset($input["localizacion"]) && $input["localizacion"] !== "") {
            $query->where("localizacion_id",$input["localizacion"]);
            $queryCount->where("localizacion_id",$input["localizacion"]);
        }
        /*if ($input["stock"] !== "") {
            $query->whereRaw("(SELECT TOP 1 producto_sucursal.stock FROM producto_sucursal WHERE producto_id=productos.id and sucursal_id=$suc) like '%" . $input["stock"] . "%'");
            $queryCount->whereRaw("(SELECT TOP 1 producto_sucursal.stock FROM producto_sucursal WHERE producto_id=productos.id and sucursal_id=$suc) like '%" . $input["stock"] . "%'");
        }*/
        $registros = $query->orderby("clave")->take($perpage)->skip($start)->get();

        if($input["paginado"]==1) {
            $count = $queryCount->count();
            $result = [
                "last" => ceil($count / $perpage),
                "anterior" => $page > 1 ? $page - 1 : $page,
                "siguiente" => $page + 1,
                "current_page" => $page,
                "data" => $registros
            ];
        }
        else{
            $result = [
                "anterior" => $page > 1 ? $page - 1 : $page,
                "siguiente" => $page + 1,
                "current_page" => $page,
                "data" => $registros
            ];
        }

        return $result;
    }
    public function getInventario2($input){

        $suc = Session::get("sucursal_id");
        $query = Inventario::withoutglobalscope('producto')->select(
            "productos.id",
            "productos.clave",
            "productos.clave2",
            "productos.descripcion",
            "producto_sucursal.stock",
            DB::raw("(SELECT categoria from categorias where productos.id = categorias_id) as categoria"),
            DB::raw("(SELECT marca from marcas where productos.id = marca_id) as marca"),
            DB::raw("(SELECT proveedor from proveedores where productos.id = proveedor_id) as proveedor"),
            DB::raw("(SELECT nombre from localizaciones where producto_sucursal.localizacion_id = localizaciones.id) as localizacion")
        )->rightjoin("productos","productos.id","=",DB::raw("producto_sucursal.producto_id and producto_sucursal.etapa=0"));


        return $query->get();
    }
}