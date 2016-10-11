<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CotacaoProdutos extends Model
{

    protected $table = 'cotacaoproduto';
    protected $primaryKey = 'idcotacaoproduto';
    protected $fillable = ["idproduto", "idprecoproduto", "idcotacao"];
    public $incrementing = false;

    public function produto()
    {
        return $this->hasOne('App\Model\Produtos', 'idproduto', 'idproduto');
    }

    public function cotacao()
    {
        return $this->belongsTo('App\Model\Cotacoes', 'idcotacao', 'idcotacao');
    }
    
  
}
