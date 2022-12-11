<?php

Route::get('/', function(){
    return redirect('/login');
});


Route::group(['middleware' => 'auth'], function () {


    Route::post("/cfdis/getEmisor","CfdiController@getEmisor");
    Route::post("/cfdis/getFolio","CfdiController@getFolio");
    Route::post("/cfdis/vistaPrevia","CfdiController@vistaPrevia");
    Route::post("/cfdis/vistaPreviaPdf","CfdiController@vistaPreviaPdf");
    Route::get("/cfdis/verPdf/{name}.pdf","CfdiController@verPdf");
    Route::get("/cfdis/verCfdi/{uuid}.pdf","CfdiController@verCfdi");
    Route::post("/cfdis/guardarComprobante","CfdiController@guardarComprobante");
    Route::post("/cfdis/timbrarComprobante","CfdiController@timbrarComprobante");
    Route::get("/cfdis/datapanel","CfdiController@datapanel");
    Route::get('/cfdis/zip/{filename}/{archivo}.zip', 'CfdiController@zip');
    Route::get('/cfdis/proforma/{id}.pdf', 'CfdiController@proforma2');
    Route::get('/cfdis/proforma/{id}', 'CfdiController@proforma');

    Route::post("/cfdis/subirArchivo","CfdiController@subirArchivo");
    Route::post("/cfdis/subirArchivo2","CfdiController@subirArchivo2");
    Route::post("/cfdis/descargarCfdi","CfdiController@descargarCfdi");
    Route::resource("cfdis","CfdiController");

    Route::post("general/partialReload","GeneralController@partialReload");
    Route::get("general/getProdServ","GeneralController@getProdServ");
    Route::get("general/getClaveUnidad","GeneralController@getClaveUnidad");
    Route::get("general/getCliente","GeneralController@getCliente");
    Route::get("general/getLugarExpedicion","GeneralController@getLugarExpedicion");
    Route::get("general/NoIdentificacion","GeneralController@NoIdentificacion");


    Route::post("/empresa/guardarDatosEmisor","EmpresaController@guardarDatosEmisor");
    Route::post("/empresa/setFolio","EmpresaController@setFolio");
    Route::get("/empresa/listSeries","EmpresaController@listSeries");
    Route::post("/empresa/borrarSerie","EmpresaController@borrarSerie");
    Route::post('/empresa/deletePhotoPerfil', 'EmpresaController@deletePhotoPerfil');
    Route::post('/empresa/uploadPhotoPerfil', 'EmpresaController@uploadPhotoPerfil');
    Route::post('/empresa/guardarCSD', 'EmpresaController@guardarCSD');
    Route::resource("empresa","EmpresaController");

    Route::post("/clientes/guardaDatosReceptor","ClienteController@guardaDatosReceptor");
    Route::post("/clientes/traerClientes","ClienteController@traerClientes");
    Route::post("/clientes/borrarCliente","ClienteController@borrarCliente");
    Route::get("/clientes/datapanel","ClienteController@datapanel");
    Route::resource("clientes","ClienteController");

    Route::get("/productos/datapanel","ProductoController@datapanel");
    Route::post("/productos/traerProductos","ProductoController@traerProductos");
    Route::post("/productos/subirArchivo","ProductoController@subirArchivo");
    Route::post("/productos/subirArchivo2","ProductoController@subirArchivo2");
    Route::post("/productos/borrarProducto","ProductoController@borrarProducto");
    Route::post("/productos/guardaProducto","ProductoController@guardaProducto");
    Route::post("/productos/getProducto","ProductoController@getProducto");
    Route::resource("productos","ProductoController");


});
