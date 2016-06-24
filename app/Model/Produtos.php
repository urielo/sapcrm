<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Produtos extends Model
{

    protected $table = 'produto';
    protected $primaryKey = 'idproduto';
    protected $fillable = ['idproduto',
        'nomeproduto',
        'descproduto',
        'caractproduto',
        'idtipoveiculo',
        'porcentindenizfipe',
        'vlrfipemaximo',
        'vlrfipeminimo',
        'qtdemaxparcelas',
        'indtabprecofipe',
        'indtabprecocategorianobre',
        'numparcelsemjuros',
        'jurosmesparcelamento',
        'indexigenciavistoria',
        'codstatus',
        'idseguradora',
        'procsusepproduto',
        'codramoproduto',
        'cobertura',];
    public $timestamps = FALSE;
    public $incrementing = false;

    public function precoproduto()
    {
        return $this->hasMany('App\Model\PrecoProduto', 'idproduto', 'idproduto');
    }
}
