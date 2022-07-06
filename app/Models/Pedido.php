<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;
    protected $table = 'pedidos';
    protected $fillable = ['data_pedido'];
    protected $hidden = ['cliente_id', 'created_at', 'updated_at'];

    public function cliente()
    {
        return $this->hasOne(Cliente::class, 'id', 'cliente_id');
    }

    public function produtos()
    {
        return $this->belongsTo(PedidoProdutos::class);
    }
}
