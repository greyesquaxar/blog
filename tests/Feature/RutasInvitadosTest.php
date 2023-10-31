<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RutasInvitadosTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testRutaIndex()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function testRutaBuscador()
    {
        $response = $this->get('/buscador');

        $response->assertStatus(200);
    }

    public function testRutaTema()
    {
        $usuario = factory(\App\User::class)->create();

        $tema = factory(\App\Theme::class)->create([
            'user_id' => $usuario->id,
            'nombre' => 'Coches',
            'slug' => 'coches'
        ]);

        $response = $this->get('/tema/coches');

        $response->assertStatus(200);

    }

    
}
