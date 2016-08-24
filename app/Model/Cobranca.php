<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Cobranca extends Model
{

    protected $table = 'cobranca';
    protected $primaryKey = 'id';
    protected $fillable = [

        'id',
        'idproposta',
        'numpagamento',
        'operadora',
        'dtvencimento',
        'dtpagamento',
        'idstatus',
        'diasdemais',
        'idcartao',
        'vlcartao',
        'parcelas',
        'usuario_id',

    ];

    public $timestamps = FALSE;

    /**
     * @return array
     */
    public function proposta()
    {
        return $this->belongsTo('App\Model\Propostas', 'idproposta', 'idproposta');
    }

    public function cartao()
    {

        return $this->hasOne('App\Model\Cartoes', 'id', 'idcartao');

    }


}
