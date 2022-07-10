<?php

namespace App\Http\Requests;

use App\Models\Cliente;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class UpdateProdutoRequest extends FormRequest
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
        $id = $this->route('id');
        return [
            'nome' => 'required|min:3',
            'cod_barras' => [
                'required',
                'min:20',
                'max:20',
                Rule::unique('produtos', 'cod_barras')->where(fn ($query) => $query->where('id', '!=', $id))
            ],
            'valor_unitario' => 'required|numeric|min:0.01'
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
            'valor_unitario.min' => 'O valor minimo do produto deve ser 0.01',
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
