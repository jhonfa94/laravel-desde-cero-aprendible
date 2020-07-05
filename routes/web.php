<?php

use Illuminate\Support\Facades\Route;

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

/* Route::get('/', function () {
    $nombre = "Jhonfa";
    return view('home',['nombre' => $nombre]);
})->name('home'); */


# Escuchamos las consultas que se generan
/* DB::listen(function($query){
    var_dump($query->sql);
}); */


Route::view('/', 'home')->name('home');
Route::view('/quienes-somos', 'about')->name('about');
Route::view('/contacto', 'contact')->name('contact');

Route::post('/contacto', 'MessageController@store')->name('messages.store');

// Route::get('/portafolio', 'ProjectController@index')->name('projects.index');
// Route::get('/portafolio/crear', 'ProjectController@create')->name('projects.create');
// Route::get('/portafolio/{project}/editar', 'ProjectController@edit')->name('projects.edit');
// Route::put('/portafolio/{project}', 'ProjectController@update')->name('projects.update');
// Route::post('/portafolio', 'ProjectController@store')->name('projects.store');
// Route::get('/portafolio/{project}', 'ProjectController@show')->name('projects.show');
// Route::delete('/portafolio/{project}', 'ProjectController@destroy')->name('projects.destroy');

Route::resource('/portafolio', 'ProjectController')
    ->names('projects')
    ->parameters(['portafolio' => 'project']);


Route::get('categorias/{category}', 'CategoryController@show')->name('categories.show');



# La siguiente ruta recibe como parametro el nombre, el cual esta opcional
/* Route::get('saludo/{nombre?}', function ($nombre = "Invitado") {
    return "Saludos $nombre";
});
 */
//Auth::routes(['register' => false]);
Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');
