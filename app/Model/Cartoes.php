<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Cartoes extends Model
{

    protected $table = 'cartoes';
    protected $primaryKey = 'id';
    protected $fillable = [

        'id',
        'bandeira',
        'numero',
        'validade',
        'cvv',
        'clicpfcnpj',
        'nome',

    ];

    public $timestamps = FALSE;

    public function segurado()
    {
        $this->belongsTo('App\Model\Segurado', 'clicpfcnpj', 'clicpfcnpj');
    }

    public function cobranca()
    {
        $this->belongsToMany('App\Model\Cobranca', 'idcartao', 'id');
    }




}
