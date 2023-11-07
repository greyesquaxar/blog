<?php

Route::get('/','WelcomeController@welcome')->name('welcome'); // index
Route::get('/tema/{tema}','ThemeController@show')->name('tema.show'); // artículos de cada tema
Route::get('/buscador','SearchController@index');

//Rutas invitados axios
Route::get('/comprobar-alias-js/{alias?}','auth\RegisterController@comprobarAlias');
Route::get('/buscador-predictivo','SearchController@buscadorPredictivo');