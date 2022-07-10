<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePedidoRequest;
use App\Http\Requests\StoreProdutoRequest;
use App\Http\Requests\UpdateProdutoRequest;
use App\Models\Pedido;
use App\Models\PedidoProduto;
use App\Models\Produto;
use Exception;
use Illuminate\Support\Facades\DB;

class PedidoController extends Controller
{

    /**
     * API de retorno de todos os Produtos
     */
    public function todos()
    {
        return response()->json(['pedido' => Pedido::with(['cliente', 'produtos'])->get(), 'tipo' => 'dados'], 200);
    }

    /**
     * API de cadastro de Produto
     */
    public function cadastro(StorePedidoRequest $request)
    {
        DB::beginTransaction();

        try {
            $pedido = Pedido::create($request->validated());
            $produtos = $request->validated('produtos_pedido');
            for($i = 0; $i < count($produtos); $i++)
                PedidoProduto::create(['pedido_id' => $pedido->id, 'produto_id' => $produtos[$i]['pivot']['produto_id'], 'quantidade' => $produtos[$i]['pivot']['quantidade']]);

            DB::commit();

            return response()->json(['mensagem' => 'Pedido cadastrado com sucesso', 'tipo' => 'sucesso'], 200);

        } catch(Exception $e) {
            DB::rollback();
            return response()->json(['mensagem' => 'Ocorreu um erro ao salvar o pedido, nenhum dado será salvo!', 'tipo' => 'geral'], 400);
        }

        // Erro geral
        return response()->json(['mensagem' => 'Ocorreu um erro ao salvar o Produto, verifique sua conexão e tente novamente!', 'tipo' => 'geral'], 400);
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
        $pedido =  Pedido::find($id);
        if(!$pedido)
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
