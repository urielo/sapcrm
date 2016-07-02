<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Combos extends Model
{
    protected $table = 'produtos_combos';
    protected $primaryKey = 'idprodutomaster';
    protected $fillable = [

        "idprodutoopcional",
        "idprodutomaster",

    ];
    public $incrementing = false;

    public function produto()
    {
        return $this->belongsTo('App\Model\Produtos', 'idprodutomaster', 'idproduto');
    }
}

