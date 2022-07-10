<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            ClienteSeeder::class,
            ProdutoSeeder::class
        ]);

        DB::table('pedidos')->insert([
            'data_pedido' => date('Y-m-d'),
            'cliente_id' => 1,
        ]);
        DB::table('pedidos')->insert([
            'data_pedido' => date('Y-m-d'),
            'cliente_id' => 2,
        ]);

        DB::table('pedidos_produtos')->insert(['pedido_id' => 1, 'produto_id' => 1, 'quantidade' => 10 ]);
        DB::table('pedidos_produtos')->insert(['pedido_id' => 1, 'produto_id' => 2, 'quantidade' => 3 ]);
        DB::table('pedidos_produtos')->insert(['pedido_id' => 1, 'produto_id' => 3, 'quantidade' => 4 ]);
        DB::table('pedidos_produtos')->insert(['pedido_id' => 1, 'produto_id' => 4, 'quantidade' => 7 ]);

        DB::table('pedidos_produtos')->insert(['pedido_id' => 2, 'produto_id' => 2, 'quantidade' => 2 ]);
        DB::table('pedidos_produtos')->insert(['pedido_id' => 2, 'produto_id' => 3, 'quantidade' => 7 ]);
        DB::table('pedidos_produtos')->insert(['pedido_id' => 2, 'produto_id' => 5, 'quantidade' => 4 ]);
        DB::table('pedidos_produtos')->insert(['pedido_id' => 2, 'produto_id' => 7, 'quantidade' => 5 ]);
    }
}
