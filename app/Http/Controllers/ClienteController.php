<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Cliente::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('clientes.formulario');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Valida o request
        $input = $request->all();
        $validator = Validator::make( $input, [
            'nome' => 'required|min:3',
            'cpf' => 'required|unique:clientes|cpf',
            'email' => 'nullable|email|unique:clientes'
        ]);

        // Retorna os erros de validação
        if($validator->fails())
            return response()->json(['mensagem' => $validator->errors(), 'tipo' => 'validacao'], 400);

        // Salva o cliente
        $cliente = Cliente::create($request->all());
        if($cliente)
            return response()->json(['mensagem' => 'Cliente cadastrado com sucesso', 'tipo' => 'sucesso'], 200);

        // Erro geral
        return response()->json(['mensagem' => 'Ocorreu um erro ao salvar o cliente, verifique sua conexão e tente novamente!', 'tipo' => 'geral'], 400);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $cliente =  Cliente::find($id);
        if(!$cliente)
            return response()->json(['mensagem' => 'Cliente não encontrado.', 'tipo' => 'geral'], 400);

        // Valida o request
        $input = $request->all();
        $validator = Validator::make( $input, [
            'nome' => 'required|min:3',
            'cpf' => 'required|unique:clientes|cpf',
            'email' => 'nullable|email|unique:clientes'
        ]);

        // Retorna os erros de validação
        if($validator->fails())
            return response()->json(['mensagem' => $validator->errors(), 'tipo' => 'validacao'], 400);

        // Atualiza o cliente
        if($cliente->update(array_filter($input)))
            return response()->json(['mensagem' => 'Cliente atualizado com sucesso.', 'tipo' => 'sucesso'], 200);

        // Erro geral
        return response()->json(['mensagem' => 'Ocorreu um erro ao editar o cliente, verifique sua conexão e tente novamente.', 'tipo' => 'geral'], 400);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Deleta o cliente
        if(Cliente::find($id)->delete())
            return response()->json(['mensagem' => 'Cliente deletado com sucesso', 'tipo' => 'sucesso'], 200);

        // Erro geral
        return response()->json(['mensagem' => 'Ocorreu um erro ao editar o cliente, verifique sua conexão e tente novamente.', 'tipo' => 'geral'], 400);
    }
}
