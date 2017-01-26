<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Combos extends Model
{
    protected $table = 'produtos_combos';
    protected $primaryKey = 'idprodutomaster';
    public $timestamps = false;
    protected $fillable = [

        "idprodutoopcional",
        "idprodutomaster",
        "tipo_veiculo_id",

    ];
    public $incrementing = false;

    public function produto()
    {
        return $this->belongsTo('App\Model\Produtos', 'idprodutomaster', 'idproduto');
    }
}

