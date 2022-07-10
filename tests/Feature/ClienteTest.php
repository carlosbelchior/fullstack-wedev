<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ClienteTest extends TestCase
{
    /** @test */
    public function ok_all_clientes()
    {
        $response = $this->get('/api/clientes/todos');
        $response->assertStatus(200);
    }

    /** @test */
    public function ok_add_cliente()
    {
        $response = $this->post('/api/clientes/cadastro', [
            'nome' => 'Carlos Belchior',
            'cpf' => '46324748006',
            'email' => 'carlosteste3@gmail.com'
        ]);
        $response->assertStatus(200);
    }

    /** @test */
    public function ok_find_cliente()
    {
        $response = $this->get('/api/clientes/encontrar/1');
        $response->assertStatus(200);
    }

    /** @test */
    public function ok_update_cliente()
    {
        $response = $this->post('/api/clientes/atualizar/1', [
            'nome' => 'Carlos Belchior',
            // CPF fake válido,
            'cpf' => '11950742040',
            'email' => 'test1@faker.test'
        ]);
        $response->assertStatus(200);
    }

    /** @test */
    public function ok_delete_cliente()
    {
        $response = $this->get('/api/clientes/exclusao/2');
        $response->assertStatus(200);
    }

    /** @test */
    public function error405_all_clientes()
    {
        $response = $this->post('/api/clientes/todos');
        $response->assertStatus(405);
    }

    /** @test */
    public function error400_add_cliente()
    {
        $response = $this->post('/api/clientes/cadastro', [
            'nome' => '',
            'cpf' => '',
            'email' => ''
        ]);
        $response->assertStatus(400);
    }

    /** @test */
    public function error400_find_cliente()
    {
        // Cliente não encontrado
        $response = $this->get('/api/clientes/encontrar/10000000');
        $response->assertStatus(400);
    }

    /** @test */
    public function error405_find_cliente()
    {
        $response = $this->post('/api/clientes/encontrar/10000000');
        $response->assertStatus(405);
    }

    /** @test */
    public function error400_update_cliente()
    {
        $response = $this->post('/api/clientes/atualizar/1', [
            'nome' => 'Carlos Belchior',
            // CPF fake válido,
            'cpf' => '12345678932',
            'email' => 'test1@faker.test'
        ]);
        $response->assertStatus(400);
    }

    /** @test */
    public function error_delete_cliente()
    {
        // cliente não encontrado
        $response = $this->get('/api/clientes/exclusao/100000');
        $response->assertStatus(400);
    }
}
