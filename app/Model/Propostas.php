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
        'codstatus',
        'nmbandeira',
        'numcartao',
        'validadecartao',

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

    public function propostaseguradora()
    {
        return $this->hasOne('App\Model\PropostasSeguradora', 'id_proposta_sap', 'idproposta');
    }
    
    public function apoliceseguradora()
    {
        return $this->hasOne('App\Model\ApolicesSeguradora', 'id_proposta_sap', 'idproposta');
    }
    
    

   


}
