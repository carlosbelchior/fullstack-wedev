<?php

use App\Http\Controllers\ClienteController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\ProdutoController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix('clientes')->controller(ClienteController::class)->group(function () {
    Route::get('/', 'lista')->name('cliente.lista');
    Route::get('/gerenciar/{id?}', 'formulario')->name('cliente.gerenciar');
});

Route::prefix('produtos')->controller(ProdutoController::class)->group(function () {
    Route::get('/', 'lista')->name('produto.lista');
    Route::get('/gerenciar/{id?}', 'formulario')->name('produto.gerenciar');
});

Route::prefix('pedidos')->controller(PedidoController::class)->group(function () {
    Route::get('/', 'lista')->name('pedido.lista');
    Route::get('/gerenciar/{id?}', 'formulario')->name('pedido.gerenciar');
});

Route::get('/', function () {
    return view('clientes.lista');
});
