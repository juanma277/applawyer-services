<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

//PAGINA INCIAL
Route::get('/', function () {
    return view('welcome');
});

//GRUPO DE RUTAS DE LOGIN
Route::group(['prefix' => 'login', 'middleware' => 'cors'], function() {
    Route::post('log', 'LogController@log');
    Route::get('logout', 'LogController@logout');    
});

//GRUPO DE RUTAS DE USUARIO
Route::group(['prefix' => 'users', 'middleware' => 'cors'], function() {
    Route::get('all', 'UserController@all');
    Route::get('paginate/{desde}', 'UserController@paginate');
    Route::get('searchUser/{termino}', 'UserController@searchUser');
    Route::get('getUser/{id}', 'UserController@getUser');
    Route::put('update/{id}', 'UserController@update');
    Route::put('updateImagen/{id}/{platform}', 'UserController@updateImagen');
    Route::put('updatePassword/{id}', 'UserController@updatePassword');
    Route::delete('delete/{id}', 'UserController@delete');
    Route::post('create', 'UserController@create');        
});

//GRUPO DE RUTAS DE TIPOS DE PROCESOS
Route::group(['prefix' => 'typeProcesses', 'middleware' => 'cors'], function() {
    Route::get('all', 'TypeProcessesController@all');
    Route::get('activos', 'TypeProcessesController@activos');
    Route::get('paginate/{desde}', 'TypeProcessesController@paginate');
    Route::get('searchType/{termino}', 'TypeProcessesController@searchType');
    Route::get('getProcesses/{id}', 'TypeProcessesController@getProcesses');
    Route::put('update/{id}', 'TypeProcessesController@update');
    Route::delete('delete/{id}', 'TypeProcessesController@delete');
    Route::post('create', 'TypeProcessesController@create');        
});

//GRUPO DE RUTAS DE PROCESOS
Route::group(['prefix' => 'processes', 'middleware' => 'cors'], function() {
    Route::get('all', 'ProcessesController@all');
    Route::get('paginate/{desde}', 'ProcessesController@paginate');
    Route::get('searchProccess/{termino}', 'ProcessesController@searchProccess');
    Route::get('searchProcesos/{termino}/{id}', 'ProcessesController@searchProcesos');
    Route::get('getProcesses/{id}', 'ProcessesController@getProcesses');
    Route::get('getProcessesUser/{id}/{desde}', 'ProcessesController@allUser');
    Route::get('porJuzgado/{id}', 'ProcessesController@porJuzgado');
    Route::get('porTipo/{id}', 'ProcessesController@porTipo');
    Route::get('porCiudad/{id}', 'ProcessesController@porCiudad');
    Route::get('porEstado/{id}', 'ProcessesController@porEstado');
    Route::put('update/{id}', 'ProcessesController@update');
    Route::put('update/status/{id}', 'ProcessesController@updateStatus');
    Route::delete('delete/{id}/{user_id}', 'ProcessesController@delete');
    Route::delete('deleteAdmin/{id}', 'ProcessesController@deleteAdmin');
    Route::post('create', 'ProcessesController@create');        
});

//GRUPO DE RUTAS DE JUZGADOS
Route::group(['prefix' => 'court', 'middleware' => 'cors'], function() {
    Route::get('all', 'CourtController@all');
    Route::get('activos', 'CourtController@activos');
    Route::get('cities/{id}', 'CourtController@courtCities');
    Route::get('paginate/{desde}', 'CourtController@paginate');
    Route::get('searchCourt/{termino}', 'CourtController@searchCourt');
    Route::get('getCourt/{id}', 'CourtController@getCourt');
    Route::put('update/{id}', 'CourtController@update');
    Route::delete('delete/{id}', 'CourtController@delete');
    Route::post('create', 'CourtController@create');        
});

//GRUPO DE RUTAS DE HISTORIAL PROCESOS
Route::group(['prefix' => 'history', 'middleware' => 'cors'], function() {
    Route::get('all', 'HistoryController@all');
    Route::get('paginate/{desde}', 'HistoryController@paginate');
    Route::get('getHistory/{id}', 'HistoryController@getHistory');
    Route::put('update/{id}', 'HistoryController@update');
    Route::delete('delete/{id}', 'HistoryController@delete');
    Route::post('create', 'HistoryController@create');        
});

//GRUPO DE RUTAS DE CIUDADES
Route::group(['prefix' => 'cities', 'middleware' => 'cors'], function() {
    Route::get('all', 'CiudadController@all');
    Route::get('activos', 'CiudadController@activos');
    Route::get('paginate/{desde}', 'CiudadController@paginate');
    Route::get('searchCity/{termino}', 'CiudadController@searchCity');
    Route::get('getCities/{id}', 'CiudadController@getCities');
    Route::put('update/{id}', 'CiudadController@update');
    Route::delete('delete/{id}', 'CiudadController@delete');
    Route::post('create', 'CiudadController@create');        
});

//GRUPO DE RUTAS PARA ENVIAR MAILS
Route::group(['prefix' => 'mails', 'middleware' => 'cors'], function() {
    Route::post('rememberPassword', 'MailController@rememberPassword');
});

//GRUPO DE RUTAS DE ALARMAS
Route::group(['prefix' => 'alarmas', 'middleware' => 'cors'], function() {
    Route::get('all', 'AlarmaController@all');
    Route::get('allAlarmas/{id}', 'AlarmaController@allAlarmas');
    Route::get('paginate/{desde}', 'AlarmaController@paginate');
    Route::get('getAlarma/{id}', 'AlarmaController@getAlarma');
    Route::put('update/{id}', 'AlarmaController@update');
    Route::delete('delete/{alarma_id}/{proceso_id}', 'AlarmaController@delete');
    Route::post('create', 'AlarmaController@create');        
});

//GRUPO DE RUTAS DE ADJUNTOS
Route::group(['prefix' => 'adjuntos', 'middleware' => 'cors'], function() {
    Route::get('all', 'AdjuntoController@all');
    Route::get('allAdjuntos/{id}', 'AdjuntoController@allAdjuntos');
    Route::get('paginate/{desde}', 'AdjuntoController@paginate');
    Route::get('getAdjunto/{id}', 'AdjuntoController@getAdjunto');
    Route::put('update/{platform}/{id}', 'AdjuntoController@update');
    Route::delete('delete/{adjunto_id}/{proceso_id}', 'AdjuntoController@delete');
    Route::post('create/{platform}', 'AdjuntoController@create');        
});

//GRUPO DE RUTAS PARA VER IMAGENES
Route::group(['prefix' => 'images', 'middleware' => 'cors'], function() {
    Route::get('adjuntos/{archivo}', 'ImagenController@adjunto');
    Route::get('users/{archivo}', 'ImagenController@users');
});

// GRUPO DE RUTAS PARA DESCARGAR PDF´s y XLS
Route::group(['prefix' => 'download', 'middleware' => 'cors'], function() {
    Route::get('PDF/procesos/{id}', 'pdfController@procesosPDF');
    Route::get('XLS/procesos/{id}', 'pdfController@procesosXLS');
    Route::get('PDF/actuacionProceso/{id}', 'pdfController@actuacionPDF');
    Route::get('XLS/actuacionProceso/{id}', 'pdfController@actuacionXLS');
    Route::get('PDF/usuarios', 'pdfController@usuariosPDF');
    Route::get('XLS/usuarios', 'pdfController@usuariosXLS');
    Route::get('PDF/tipos', 'pdfController@tiposPDF');
    Route::get('XLS/tipos', 'pdfController@tiposXLS');
    Route::get('PDF/juzgados', 'pdfController@juzgadosPDF');
    Route::get('XLS/juzgados', 'pdfController@juzgadosXLS'); 
    Route::get('PDF/Aprocesos', 'pdfController@AprocesosPDF');
    Route::get('XLS/Aprocesos', 'pdfController@AprocesosXLS');  
});

// GRUPO DE RUTAS PARA NOTIFICACIONES
Route::group(['prefix' => 'notifications', 'middleware' => 'cors'], function() {
    Route::get('all', 'NotificacionController@all');
    Route::get('activos', 'NotificacionController@activos');
    Route::get('paginate/{desde}', 'NotificacionController@paginate');
    Route::get('searchNotificacion/{termino}', 'NotificacionController@searchNotificacion');
    Route::get('getNotificacion/{id}', 'NotificacionController@getNotificacion');
    Route::put('update/{id}', 'NotificacionController@update');
    Route::delete('delete/{notificacion_id}', 'NotificacionController@delete');
    Route::post('create', 'NotificacionController@create'); 
});