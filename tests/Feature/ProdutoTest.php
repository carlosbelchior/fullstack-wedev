<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProdutoTest extends TestCase
{
    /** @test */
    public function ok_all_produtos()
    {
        $response = $this->get('/api/produtos/todos');
        $response->assertStatus(200);
    }

    /** @test */
    public function ok_add_produto()
    {
        $response = $this->post('/api/produtos/cadastro', [
            'nome' => 'Coca Cola 2L',
            'cod_barras' => '12345678912345678912',
            'valor_unitario' => 10.02
        ]);
        $response->assertStatus(200);
    }

    /** @test */
    public function ok_find_produto()
    {
        $response = $this->get('/api/produtos/encontrar/1');
        $response->assertStatus(200);
    }

    /** @test */
    public function ok_update_produto()
    {
        $response = $this->post('/api/produtos/atualizar/1', [
            'nome' => 'Coca Cola 2L',
            'cod_barras' => '12345678912345678932',
            'valor_unitario' => 11.02
        ]);
        $response->assertStatus(200);
    }

    /** @test */
    public function ok_delete_produto()
    {
        $response = $this->get('/api/produtos/exclusao/50 ');
        $response->assertStatus(200);
    }

    /** @test */
    public function error405_all_produtos()
    {
        $response = $this->post('/api/produtos/todos');
        $response->assertStatus(405);
    }

    /** @test */
    public function error400_add_produto()
    {
        $response = $this->post('/api/produtos/cadastro', [
            'nome' => '',
            'cod_barras' => '',
            'valor_unitario' => ''
        ]);
        $response->assertStatus(400);
    }

    /** @test */
    public function error400_find_produto()
    {
        // produto não encontrado
        $response = $this->get('/api/produtos/encontrar/10000000');
        $response->assertStatus(400);
    }

    /** @test */
    public function error405_find_produto()
    {
        $response = $this->post('/api/produtos/encontrar/10000000');
        $response->assertStatus(405);
    }

    /** @test */
    public function error400_update_produto()
    {
        $response = $this->post('/api/produtos/atualizar/1', [
            'nome' => 'Coca Cola 2L',
            'cod_barras' => '12345678912345678912',
            'valor_unitario' => 11.02
        ]);
        $response->assertStatus(400);
    }

    /** @test */
    public function error400_delete_produto()
    {
        // Produto não encontrado
        $response = $this->get('/api/produtos/exclusao/10000');
        $response->assertStatus(400);
    }
}
