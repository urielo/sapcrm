<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CustoProduto extends Model
{
    protected $table = 'custo_produto';
    protected $fillable = [
        'idseguradora',
        'idproduto',
        'idprecoproduto',
        'custo_mensal',
        'custo_anual',
        'dt_create',
        'id',
    ];


    public function produto()
    {
        return $this->belongsTo('App\Model\Produtos','idproduto','idproduto');
    }


    public function seguradora()
    {
        return $this->belongsTo('App\Model\Seguradora','idseguradora','idseguradora');
    }
    /**
     * @return array
     */
    /**
     * @return array
     */

}
