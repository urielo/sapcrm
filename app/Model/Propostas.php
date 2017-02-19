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
        'cvvcartao',
        'idmotivo',
        'premiototal',
        'primeiraparc',
        'demaisparc',
        'usuario_id',
        'titularcartao',
        'veiculo_id',
        'created_at',
        'updated_at',

    ];

    public function cotacao()
    {
        return $this->belongsTo('App\Model\Cotacoes', 'idcotacao', 'idcotacao');
    }
    
    

    public function veiculo()
    {
        return $this->belongsTo('App\Model\Veiculos','veiculo_id','veicid');
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

    public function status(){
        return $this->belongsTo('App\Model\Status','idstatus','id');

    }

    public function motivos(){
        return $this->belongsTo('App\Model\Motivos','idmotivo','id');

    }

    /**
     * @return array
     */
    public function cancelado()
    {
        return $this->hasOne(Cancelamentos::class,'cancelado_id','idproposta')->where('cancelado_desc','proposta')->with('motivo');
    }


    
    
    

   


}
