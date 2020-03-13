<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes();

//Mostrar proyectos (Vista por default del sistema)
Route::get('/', function () {
    //return view('welcome');
    return view('proyects');
});

//Mostrar proyectos
Route::get('/proyects', function () {
    return view('proyects');
});

//Mostrar publicaciones
Route::get('/pubs', function () {
    return view('pubs');
});

Route::get('/home', 'HomeController@index')->name('home');

//Personalizar grupos de investigación
Route::get('gestionargrupos', 'Auth\RegisterGestionarGruposController@showRegistrationForm')->name('gestionargrupos');
Route::post('gestionargrupos', 'Auth\RegisterGestionarGruposController@upload');


//Registrar nuevo investigador
Route::get('registerinv', 'Auth\RegisterInvController@showRegistrationForm')->name('registerinv');
Route::post('registerinv', 'Auth\RegisterInvController@register');
//Editar Informacion del investigador
Route::put('registerinv', 'Auth\RegisterInvController@edit');
Route::put('registerproject', 'Auth\RegisterProjectController@edit');

//Registrar nuevo proyecto
Route::get('registerproject', 'Auth\RegisterProjectController@showRegistrationForm')->name('registerproject');
Route::post('registerproject', 'Auth\RegisterProjectController@register');

//Registrar nueva publicacion
Route::get('registerpub', 'Auth\RegisterPubController@showRegistrationForm')->name('registerpub');
Route::post('registerpub', 'Auth\RegisterPubController@register');

Route::get('registerpubinv', 'Auth\RegisterPubController@showRegistrationForm')->name('registerpubinv');
Route::post('registerpubinv', 'Auth\RegisterPubController@registerpubinv');
Route::post('extinv', 'Auth\RegisterPubController@addextinv');