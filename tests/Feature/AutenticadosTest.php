<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AutenticadosTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testAutenticadoPuedeAccederRutaHome()
    {
        $usuario = factory(\App\User::class)->create([
            'email_verified_at' => date('Y-m-d H:i:s')
        ]);
        $this->actingAs($usuario);
        $response = $this->get('/home');
        $response->assertStatus(200);
    }

    public function testAutenticadoPuedeModificarSusDatos()
    {
        $usuario=factory(\App\User::class)->create([  
            'email_verified_at'   =>  date("Y-m-d H:i:s") // NOW() ó CURRENT_TIME()
        ]);
        $this->actingAs($usuario);
        $this->put(url('/usuario-actualizar'),[
            'nombre'    =>  'Miguel', 
            'alias'     =>  'miguelito', 
            'web'       =>  'www.web.com', 
            'password'  =>  bcrypt('12345'),
        ]);
        $usuario=\App\User::first();
        $this->assertSame($usuario->name,'Miguel');
    }

    public function testAutenticadoBloqueadoNoPuedeVerTemaSuscripcion()
    {
        $usuario=factory(\App\User::class)->create([
            'bloqueado'           =>  1,
            'email_verified_at'   =>  date("Y-m-d H:i:s") // NOW() ó CURRENT_TIME()
        ]);
        $this->actingAs($usuario);
        $tema=factory(\App\Theme::class)->create([
            'user_id'       =>  $usuario->id,
            'nombre'        =>  'Coches',
            'slug'          =>  'coches',
            'suscripcion'   =>  '1'   
        ]);
        $response = $this->get('/tema/coches');
        //$response->assertStatus(200);
        $response->assertSee('Para, Por favor!');
    }

    public function testAutenticadoBloqueadoNoPuedeVerArticuloSuscripcion()
    {
        $usuario=factory(\App\User::class)->create([
            'bloqueado'           =>  1,
            'email_verified_at'   =>  date("Y-m-d H:i:s") // NOW() ó CURRENT_TIME()
        ]);
        $this->actingAs($usuario);
        $tema=factory(\App\Theme::class)->create([
            'user_id'       =>  $usuario->id,
            'nombre'        =>  'Coches',
            'slug'          =>  'coches',
            'suscripcion'   =>  '1'   
        ]);
        $articulo=factory(\App\Article::class)->create([
            'titulo'       =>  'Mercedes',
            'contenido'    =>  'Este es un mercedes',
            'theme_id'     =>  $tema->id,
            'user_id'      =>  $usuario->id    
        ]);
        $response = $this->get('/buscador');
        //$response->assertStatus(200);
        //$response->assertSee('0 articulos'); // Probar otra cosa
        $response->assertDontSee(e($articulo->titulo));
    } 
}
