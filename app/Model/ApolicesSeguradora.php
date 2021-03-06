<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ApolicesSeguradora extends Model
{

    protected $table = 'apolice_seguradora';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id_proposta_sap',
        'id_config_seguradora',
        'id_cotacao_seguradora',
        'id_proposta_seguradora',
        'id_endosso_seguradora',
        'dt_instalacao_rastreador',
        'dt_ativa_rastreador',
        'dt_inicio_comodato',
        'dt_fim_comodato',
        'cd_retorno_seguradora',
        'nm_retorno_seguradora',
        'dt_criacao',
        'dt_update',
        'xml_saida',
        'xml_retorno',
        'id_apolice_seguradora',
        'cd_apolice_seguradora',
        'status_id',
    ];
    
    public $timestamps = FALSE;

    

    public function proposta()
    {
        return $this->belongsTo('App\Model\Propostas', 'id_proposta_sap', 'idproposta')->with('cotacao');
    }
    
    public function cotacaoseguradora()
    {
        return $this->belongsTo('App\Model\CotacoesSeguradora', 'id_cotacao_seguradora', 'id_cotacao_seguradora');
    }
    
    public function propostaseguradora()
    {
        return $this->belongsTo('App\Model\PropostasSeguradora', 'id_proposta_seguradora', 'id_proposta_seguradora');
    }


    public function configSeguradora()
    {
        return $this->hasOne('App\Model\ConfigSeguradora','id_config_seguradora','id');
    }

    public function certificado()
    {
        return $this->belongsTo('App\Model\Certificados','id_apolice_seguradora','id');
    }

    /**
     * @return array
     */
    public function cancelado()
    {
        return $this->hasOne(Cancelamentos::class,'cancelado_id','id')->where('cancelado_desc','apolice')->with('motivo');
    }
   

    


}
