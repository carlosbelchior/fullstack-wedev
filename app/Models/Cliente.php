<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;
    protected $table = 'clientes';
    protected $fillable = ['nome', 'cpf', 'email'];
    protected $hidden = ['created_at', 'updated_at'];

    public function pedidos()
    {
        return $this->hasMany(PedidoProduto::class, 'id', 'cliente_id');
    }
}
