<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;
    protected $table = 'pedidos';
    protected $fillable = ['data_pedido', 'cliente_id', 'status'];
    protected $hidden = ['created_at', 'updated_at'];

    public function cliente()
    {
        return $this->hasOne(Cliente::class, 'id', 'cliente_id');
    }

    public function produtos()
    {
        return $this->belongsToMany(Produto::class, 'pedidos_produtos', 'pedido_id', 'produto_id')->withPivot(["pedido_id", 'produto_id', 'quantidade']);
    }
}
