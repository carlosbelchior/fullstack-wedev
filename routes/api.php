<?php

use App\Http\Controllers\ClienteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('clientes')->controller(ClienteController::class)->group(function () {
    Route::get('/todos', 'todos');
    Route::get('/encontrar/{id}', 'encontrar');
    Route::post('/cadastro', 'cadastro');
    Route::post('/atualizar/{id}', 'atualizar');
    Route::get('/exclusao/{id}', 'exclusao');
});
