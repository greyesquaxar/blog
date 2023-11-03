<?php

Route::get('/','WelcomeController@welcome')->name('welcome'); // index
Route::get('/tema/{tema}','ThemeController@show')->name('tema.show'); // artículos de cada tema
Route::get('/buscador','SearchController@index');
