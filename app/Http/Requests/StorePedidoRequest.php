<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StorePedidoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'cliente_id' => 'required|integer',
            'data_pedido' => 'required|date',
            'produtos_pedido' => 'required|array|min:1'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'cliente_id.required' => 'Você deve informar o cliente.',
            'produtos_pedido.required' => 'Você deve informar os produtos deste pedido.',
            'produtos_pedido.min' => 'O pedido deve ter pelo menos 1 produto.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
        'mensagem' => $validator->errors(),
        'tipo' => 'validacao'
        ], 400));
    }
}
