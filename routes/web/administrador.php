<?php

Route::middleware(['auth','role:administrador'])->group(function(){
    Route::get('admin/temas','admin\ThemeController@index');
    Route::delete('admin/temas/{tema}','admin\ThemeController@destroy')->name('tema.delete');
    Route::get('admin/temas/{tema}/edit','admin\ThemeController@edit')->name('tema.edit');
    Route::put('admin/temas/{tema}','admin\ThemeController@update')->name('tema.update');
    Route::get('admin/temas/create','admin\ThemeController@create')->name('tema.create');
    Route::post('admin/temas','admin\ThemeController@store')->name('tema.store');

    Route::resource('admin/articulos','admin\ArticleController');
    Route::get('admin/eliminar-todos-articulos','admin\ArticleController@eliminarTodosArticulos');
	Route::get('admin/articulos-datatable','admin\ArticleController@articulosDatatable');
    Route::delete('admin/imagenes/{imagen}','admin\ArticleImageController@destroy')->name('imagen.delete');
    Route::get('admin/inputs-file/{id}','admin\ArticleController@showInputsFile');
    Route::get('admin/buscador/articulos','admin\SearchArticleController@index');

    Route::get('admin/articulos-borrados','admin\ArticleDeleteController@index')->name('articulos-borrados.index');
    Route::put('admin/articulos-borrados/{articulo_id}','admin\ArticleDeleteController@restaurar')->name('articulos-borrados.restaurar');
    Route::delete('admin/articulos-borrados/{articulo_id}','admin\ArticleDeleteController@destroy')->name('articulos-borrados.destroy');
    Route::get('admin/articulos-borrados/{articulo_id}','admin\ArticleDeleteController@show')->name('articulos-borrados.show');
    
    Route::resource('admin/usuarios','admin\UserController')->only(['index','edit','update']);
    Route::get('admin/buscador/usuarios','admin\SearchUserController@index');

    Route::get('admin/correo-masivo','admin\CorreoMasivoController@index');
    Route::post('admin/correo-masivo','admin\CorreoMasivoController@correoMasivo');

    Route::delete('admin/eliminar-todos-articulos','admin\ArticleDeleteAll@eliminarTodosArticulos');

    // Slider
	Route::resource('admin/slider','admin\SliderController')->only(['index','store','destroy']);
	Route::get('admin/imagenes-slider','admin\SliderController@imagenesMostrarAxios');
	Route::get('admin/imagenes-ordenar/{posicionInicial}/{posicionFinal}/{ultimo}','admin\SliderController@imagenesOrdenarAxios');


});