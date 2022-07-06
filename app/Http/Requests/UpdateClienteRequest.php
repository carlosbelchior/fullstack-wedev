<?php

namespace App\Http\Requests;

use App\Models\Cliente;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class UpdateClienteRequest extends FormRequest
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
            'cpf' => [
                'required',
                'cpf',
                Rule::unique('clientes', 'cpf')->where(fn ($query) => $query->where('id', '!=', $id))
            ],
            'email' => [
                'nullable',
                'email',
                Rule::unique('clientes')->ignore($id)
            ]
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
