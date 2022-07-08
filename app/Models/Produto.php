<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    use HasFactory;
    protected $table = 'produtos';
    protected $fillable = ['nome', 'cod_barras', 'valor_unitario'];
    protected $hidden = ['created_at', 'updated_at'];

    protected $casts = ['valor_unitario' => 'decimal:2'];

    public function pedidos()
    {
        return $this->hasMany(PedidoProduto::class, 'id', 'produto_id');
    }
}
