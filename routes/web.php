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


// Rutas invitados
Route::get('/','WelcomeController@welcome')->name('welcome'); // index
Route::get('/tema/{tema}','ThemeController@show')->name('tema.show'); // artículos de cada tema
Route::get('/buscador','SearchController@index');

// Rutas Usuarios Autenticados
Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home')->middleware('verified');	
Route::put('/usuario-actualizar','UserController@update');

// Rutas Administrador
Route::middleware(['auth','role:administrador'])->group(function(){
    Route::get('admin/temas','admin\ThemeController@index');
    Route::delete('admin/temas/{tema}','admin\ThemeController@destroy')->name('tema.delete');
    Route::get('admin/temas/{tema}/edit','admin\ThemeController@edit')->name('tema.edit');
    Route::put('admin/temas/{tema}','admin\ThemeController@update')->name('tema.update');
    Route::get('admin/temas/create','admin\ThemeController@create')->name('tema.create');
    Route::post('admin/temas','admin\ThemeController@store')->name('tema.store');

    Route::resource('admin/articulos','admin\ArticleController');
    Route::get('admin/imagenes/{imagen}','admin\ArticleImageController@destroy')->name('imagen.delete');
    Route::get('admin/buscador/articulos','admin\SearchArticleController@index');

    Route::get('admin/articulos-borrados','admin\ArticleDeleteController@index')->name('articulos-borrados.index');
    Route::put('admin/articulos-borrados/{articulo_id}','admin\ArticleDeleteController@restaurar')->name('articulos-borrados.restaurar');
    Route::delete('admin/articulos-borrados/{articulo_id}','admin\ArticleDeleteController@destroy')->name('articulos-borrados.destroy');
    Route::get('admin/articulos-borrados/{articulo_id}','admin\ArticleDeleteController@show')->name('articulos-borrados.show');
    
    Route::resource('admin/usuarios','admin\UserController')->only(['index','edit','update']);
    Route::get('admin/buscador/usuarios','admin\SearchUserController@index');

    Route::get('admin/correo-masivo','admin\CorreoMasivoController@index');
    Route::post('admin/correo-masivo','admin\CorreoMasivoController@correoMasivo');

});

// Rutas Moderador
Route::middleware(['auth','verified','role:moderador'])->group(function(){
    Route::resource('moderador/articulos','moderador\ArticleController', ['names' => [
		'index'  => 'moderador.articulos.index', 
	    'create' => 'moderador.articulos.create',
	    'store' => 'moderador.articulos.store',
	    'show' => 'moderador.articulos.show',
	    'edit' => 'moderador.articulos.edit',
	    'update' => 'moderador.articulos.update',
	    'destroy' => 'moderador.articulos.destroy',
	]]);
    Route::get('moderador/imagenes/{imagen}','moderador\ArticleImageController@destroy')->name('moderador.imagen.delete');
    Route::get('moderador/buscador/articulos','moderador\SearchArticleController@index');
});