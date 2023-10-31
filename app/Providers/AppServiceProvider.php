<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use App\Theme;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(190);

        View::composer(['layouts.app','admin.articulos.create','admin.articulos.edit','moderador.articulos.create','moderador.articulos.edit'], function($view)
        {
            $temasTodos=Theme::all();
            $view->with(compact('temasTodos'));
        });
    }
}
