<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Propostas extends Model
{

    protected $table = 'proposta';
    protected $primaryKey = 'idproposta';
    protected $fillable = [
        'idproposta',
        'idcotacao',
        'idformapg',
        'quantparc',
        'dtvalidade',
        'dtcreate',
        'idstatus',
        'nmbandeira',
        'numcartao',
        'validadecartao',
        'idmotivo',
        'premiototal',
        'primeiraparc',
        'demaisparc',
        'usuario_id',

    ];
    public $timestamps = FALSE;

    public function cotacao()
    {
        return $this->belongsTo('App\Model\Cotacoes', 'idcotacao', 'idcotacao');
    }

    public function cotacaoseguradora()
    {
        return $this->hasOne('App\Model\CotacoesSeguradora', 'id_proposta_sap', 'idproposta');
    }
    public function formapg()
    {
        return $this->hasOne('App\Model\FormaPagamento', 'idformapgto', 'idformapg');
    }

    public function propostaseguradora()
    {
        return $this->hasOne('App\Model\PropostasSeguradora', 'id_proposta_sap', 'idproposta');
    }
    public function cobranca()
    {
        return $this->hasOne('App\Model\Cobranca', 'idproposta', 'idproposta');
    }
    public function cobrancas()
    {
        return $this->hasMany('App\Model\Cobranca', 'idproposta', 'idproposta');
    }
    
    public function apoliceseguradora()
    {
        return $this->hasMany('App\Model\ApolicesSeguradora', 'id_proposta_sap', 'idproposta');
    }


    public function certificado()
    {
        return $this->hasOne('App\Model\Certificados','idproposta','idproposta');
    }
    
    
    
    
    

   


}
