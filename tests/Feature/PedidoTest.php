<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PedidoTest extends TestCase
{
    /** @test */
    public function ok_all_pedidos()
    {
        $response = $this->get('/api/pedidos/todos');
        $response->assertStatus(200);
    }

    /** @test */
    public function ok_add_pedido()
    {
        $response = $this->post('/api/pedidos/cadastro', [
            "cliente_id" => 20,
            "data_pedido" => "2022-07-10",
            "status" => 1,
            "produtos_pedido" => [
                0 => [
                    "pivot" =>
                    [
                        "pedido_id" => 3,
                        "produto_id" => 4,
                        "quantidade" => 3
                    ]
                ],
                1 => [
                    "pivot" =>
                    [
                        "pedido_id" => 3,
                        "produto_id" => 5,
                        "quantidade" => 3
                    ]
                ],
                2 => [
                    "pivot" =>
                    [
                        "pedido_id" => 3,
                        "produto_id" => 6,
                        "quantidade" => 3
                    ]
                ],
            ]
        ]);
        $response->assertStatus(200);
    }

    /** @test */
    public function ok_find_pedido()
    {
        $response = $this->get('/api/pedidos/encontrar/1');
        $response->assertStatus(200);
    }

    /** @test */
    public function ok_update_pedido()
    {
        $response = $this->post('/api/pedidos/atualizar/3', [
            "cliente_id" => 20,
            "data_pedido" => "2022-07-10",
            "status" => 1,
            "produtos_pedido" => [
                0 => [
                    "pivot" =>
                    [
                        "pedido_id" => 3,
                        "produto_id" => 4,
                        "quantidade" => 3
                    ]
                ],
                1 => [
                    "pivot" =>
                    [
                        "pedido_id" => 3,
                        "produto_id" => 5,
                        "quantidade" => 9
                    ]
                ],
            ]
        ]);
        $response->assertStatus(200);
    }

    /** @test */
    public function ok_delete_pedido()
    {
        $response = $this->get('/api/pedidos/exclusao/1');
        $response->assertStatus(200);
    }

    /** @test */
    public function error405_all_pedidos()
    {
        $response = $this->post('/api/pedidos/todos');
        $response->assertStatus(405);
    }

    /** @test */
    public function error400_add_pedido()
    {
        $response = $this->post('/api/pedidos/cadastro', [
            "data_pedido" => "2022-07-10",
            "status" => 1,
            "produtos_pedido" => [
                0 => [
                    "pivot" =>
                    [
                        "pedido_id" => 3,
                        "produto_id" => 4,
                        "quantidade" => 3
                    ]
                ],
                1 => [
                    "pivot" =>
                    [
                        "pedido_id" => 3,
                        "produto_id" => 5,
                        "quantidade" => 9
                    ]
                ],
            ]
        ]);
        $response->assertStatus(400);
    }

    /** @test */
    public function error400_find_pedido()
    {
        // pedido não encontrado
        $response = $this->get('/api/pedidos/encontrar/10000000');
        $response->assertStatus(400);
    }

    /** @test */
    public function error405_find_pedido()
    {
        $response = $this->post('/api/pedidos/encontrar/10000000');
        $response->assertStatus(405);
    }

    /** @test */
    public function error400_update_pedido()
    {
        $response = $this->post('/api/pedidos/atualizar/1', [
            "cliente_id" => 20,
            "data_pedido" => "2022-07-10",
            "status" => 1,
            "produtos_pedido" => []
        ]);
        $response->assertStatus(400);
    }

    /** @test */
    public function error400_delete_pedido()
    {
        // pedido não encontrado
        $response = $this->get('/api/pedidos/exclusao/10000');
        $response->assertStatus(400);
    }
}
