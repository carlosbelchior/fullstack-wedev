<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProdutoRequest;
use App\Http\Requests\UpdateProdutoRequest;
use App\Models\Pedido;
use App\Models\Produto;

class PedidoController extends Controller
{

    /**
     * API de retorno de todos os Produtos
     */
    public function todos()
    {
        return response()->json(['pedido' => Pedido::with(['cliente'])->get(), 'tipo' => 'dados'], 200);
    }

    /**
     * Página de formulário de cadastro e edição
     */
    public function formulario()
    {
        return view('Produtos.formulario');
    }

    /**
     * API de cadastro de Produto
     */
    public function cadastro(StoreProdutoRequest $request)
    {
        // Salva o Produto
        $produto = Produto::create($request->validated());
        if($produto)
            return response()->json(['mensagem' => 'Produto cadastrado com sucesso', 'tipo' => 'sucesso'], 200);

        // Erro geral
        return response()->json(['mensagem' => 'Ocorreu um erro ao salvar o Produto, verifique sua conexão e tente novamente!', 'tipo' => 'geral'], 400);
    }

    /**
     * Página de exiibição do Produto
     */
    public function detalhes()
    {
       return view('Produtos.Produto');
    }

    /**
     * API de busca do Produto
     */
    public function encontrar($id)
    {
        // Busca o Produto
        if(Produto::find($id))
            return response()->json(['Produto' => Produto::with('pedidos')->find($id), 'tipo' => 'dados'], 200);

        // Erro geral
        return response()->json(['mensagem' => 'Produto não encontrado.', 'tipo' => 'geral'], 400);
    }

    /**
     * API de atualização do Produto
     */
    public function atualizar(UpdateProdutoRequest $request, $id)
    {
        $produto =  Produto::find($id);
        if(!$produto)
            return response()->json(['mensagem' => 'Produto não encontrado.', 'tipo' => 'geral'], 400);

        // Atualiza o Produto
        if($produto->update(array_filter($request->validated())))
            return response()->json(['mensagem' => 'Produto atualizado com sucesso.', 'tipo' => 'sucesso'], 200);

        // Erro geral
        return response()->json(['mensagem' => 'Ocorreu um erro ao editar o Produto, verifique sua conexão e tente novamente.', 'tipo' => 'geral'], 400);
    }

    /**
     * API de exclusão do Produto
     */
    public function exclusao($id)
    {
        $pedido = Pedido::find($id);

        // Verifica se o Produto existe
        if(!$pedido)
            return response()->json(['mensagem' => 'Pedido não encontrado.', 'tipo' => 'geral'], 400);

        // Deleta o Produto
        if(Pedido::destroy($id))
            return response()->json(['mensagem' => 'Pedido deletado com sucesso', 'tipo' => 'sucesso'], 200);

        // Erro geral
        return response()->json(['mensagem' => 'Ocorreu um erro ao editar o Produto, verifique sua conexão e tente novamente.', 'tipo' => 'geral'], 400);
    }
}
