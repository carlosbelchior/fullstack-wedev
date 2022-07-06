<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClienteRequest;
use App\Http\Requests\UpdateClienteRequest;
use App\Models\Cliente;

class ClienteController extends Controller
{
    /**
     * Página de listagem de clientes
     */
    public function lista()
    {
        return view('clientes.lista');
    }

    /**
     * API de retorno de todos os clientes
     */
    public function todos()
    {
        return response()->json(['cliente' => Cliente::all(), 'tipo' => 'dados'], 200);
    }

    /**
     * Página de formulário de cadastro e edição
     */
    public function formulario()
    {
        return view('clientes.formulario');
    }

    /**
     * API de cadastro de cliente
     */
    public function cadastro(StoreClienteRequest  $request)
    {
        // Salva o cliente
        $cliente = Cliente::create($request->validated());
        if($cliente)
            return response()->json(['mensagem' => 'Cliente cadastrado com sucesso', 'tipo' => 'sucesso'], 200);

        // Erro geral
        return response()->json(['mensagem' => 'Ocorreu um erro ao salvar o cliente, verifique sua conexão e tente novamente!', 'tipo' => 'geral'], 400);
    }

    /**
     * Página de exiibição do cliente
     */
    public function detalhes()
    {
       return view('clientes.cliente');
    }

    /**
     * API de busca do cliente
     */
    public function encontrar($id)
    {
        // Busca o cliente
        if(Cliente::find($id))
            return response()->json(['cliente' => Cliente::with('pedidos')->find($id), 'tipo' => 'dados'], 200);

        // Erro geral
        return response()->json(['mensagem' => 'Cliente não encontrado.', 'tipo' => 'geral'], 400);
    }

    /**
     * API de atualização do cliente
     */
    public function atualizar(UpdateClienteRequest $request, $id)
    {
        $cliente =  Cliente::find($id);
        if(!$cliente)
            return response()->json(['mensagem' => 'Cliente não encontrado.', 'tipo' => 'geral'], 400);

        // Atualiza o cliente
        if($cliente->update(array_filter($request->validated())))
            return response()->json(['mensagem' => 'Cliente atualizado com sucesso.', 'tipo' => 'sucesso'], 200);

        // Erro geral
        return response()->json(['mensagem' => 'Ocorreu um erro ao editar o cliente, verifique sua conexão e tente novamente.', 'tipo' => 'geral'], 400);
    }

    /**
     * API de exclusão do cliente
     */
    public function exclusao($id)
    {
        $cliente = Cliente::find($id);

        // Verifica se o cliente existe
        if(!$cliente)
            return response()->json(['mensagem' => 'Cliente não encontrado.', 'tipo' => 'geral'], 400);

        // Deleta o cliente
        if($cliente->delete())
            return response()->json(['mensagem' => 'Cliente deletado com sucesso', 'tipo' => 'sucesso'], 200);

        // Erro geral
        return response()->json(['mensagem' => 'Ocorreu um erro ao editar o cliente, verifique sua conexão e tente novamente.', 'tipo' => 'geral'], 400);
    }
}
