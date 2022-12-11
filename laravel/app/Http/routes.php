<?php
Route::get('/', function () {
    return redirect("/v2/notas");
});
Route::get('/contact','SitioController@contact');
Route::get('/about','SitioController@about');
Route::get('/projects','SitioController@projects');
Route::get('/blog/cat/{categoria}','SitioController@blogCategoria');
Route::get('/blog/tipo/{tipo}','SitioController@blogTipo');
Route::get('/blog/{id}/{slug}','SitioController@blogShow');


Route::get('/v2', function () {
    return redirect("/v2/notas");
});
Route::get('/v2/notas','Sitio2Controller@notas');
Route::post('/v2/storenotas','Sitio2Controller@storenotas');
Route::get('/v2/notas/{id}','Sitio2Controller@show');
Route::get('/v2/show','Sitio2Controller@show');
Route::get('/v2/services','Sitio2Controller@services');
Route::get('/v2/skills','Sitio2Controller@skills');
Route::get('/v2/experience','Sitio2Controller@experience');
Route::get('/v2/work','Sitio2Controller@work');
Route::get('/v2/contact','Sitio2Controller@contact');
Route::post('/v2/register','Sitio2Controller@register');
Route::post('/v2/comentar','Sitio2Controller@comentar');
Route::post('/v2/getComentarios','Sitio2Controller@getComentarios');
Route::post('/v2/borrarComentarios','Sitio2Controller@borrarComentarios');
Route::post('/v2/megusta','Sitio2Controller@megusta');
Route::post('/v2/dologin','Sitio2Controller@dologin');


Route::get('/notfound', function () {
    return view('error404');
});
Route::get('/clear-cache', 'GeneralController@cache');

Route::group(['middleware' => 'web'], function () {
    Route::auth();
    Route::group(['prefix' => 'game'], function () {
        Route::get('/{id}/delete', 'GameController@destroy');
        Route::get('/{id}/clean', 'GameController@clean');
        Route::post('/nuevoJuego', 'GameController@nuevoJuego');
        Route::post('/demoJuego', 'GameController@demoJuego');
        Route::post('/getJuegos', 'GameController@getJuegos');
        Route::post('/getPredicciones', 'GameController@getPredicciones');
        Route::post('/loadJuego', 'GameController@loadJuego');
        Route::post('/insertTirada', 'GameController@insertTirada');
        Route::post('/hacerApuesta', 'GameController@hacerApuesta');
    });
    Route::resource('game', 'GameController');
    Route::resource('blog', 'BlogController');
    Route::group(['prefix' => 'cuentas'], function () {
        Route::get('/{id}/delete', 'CuentaController@destroy');
        Route::post('/mercadolibre', 'CuentaController@mercadolibre');
        Route::post('/bbva', 'CuentaController@bbva');
        Route::post('/nu', 'CuentaController@nu');
        Route::post('/rappi', 'CuentaController@rappi');
        Route::post('/bills', 'CuentaController@bills');
        Route::post('/listCuentas', 'CuentaController@listCuentas');
        Route::post('/listMercadoLibre', 'CuentaController@listMercadoLibre');
        Route::post('/listPagos', 'CuentaController@listPagos');
        Route::post('/storeCuentas', 'CuentaController@storeCuentas');
        Route::post('/storeCorte', 'CuentaController@storeCorte');
        Route::post('/storePagos', 'CuentaController@storePagos');
        Route::post('/storeSaldo', 'CuentaController@storeSaldo');
        Route::get('/{id}/pdf', 'CuentaController@pdf');
    });
    Route::resource('cuentas', 'CuentasController');
});


