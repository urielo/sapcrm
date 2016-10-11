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


    /**
     * @return array
     */
    /**
     * @return array
     */

}
