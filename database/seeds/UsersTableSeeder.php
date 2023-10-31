<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Theme;
use App\Article;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users=factory(User::class,10)->create();
        $users->each(function ($user) {
            $user->roles()->sync(1); 
        });
        /*$users->each(function($user){
            $themes=factory(Theme::class,1)->make();
            $user->themes()->saveMany($themes);

            $themes->each(function($theme){
                $articles=factory(Article::class,5)->make();
                $theme->articles()->saveMany($articles);
            });

        });*/
    }
}
