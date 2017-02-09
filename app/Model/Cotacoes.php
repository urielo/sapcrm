<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Cotacoes extends Model
{

    protected $table = 'cotacao';
    protected $primaryKey = 'idcotacao';
    protected $fillable = [
        'idcotacao',
        'idparceiro',
        'idcorretor',
        'segurado_id',
        'veicid',
        'premio',
        'comissao',
        'idstatus',
        'dtvalidade',
        'dtcreate',
        'dtupdate',
        'usuario_id',
        'renova',
        'code_fipe',
        'ano_veiculo',
        'combustivel_id',
        'tipo_veiculo_id',
        'ind_veiculo_zero',
        'validade',
        'created_at',
        'updated_at',
    ];
    public $timestamps = FALSE;
    
    
    
    public function corretor()
    {
        return $this->belongsTo('App\Model\Corretores','idcorretor','idcorretor');
    }
    public function fipe()
    {
        return $this->belongsTo('App\Model\Fipes','code_fipe','codefipe');
    }
    public function segurado()
    {
        return $this->belongsTo('App\Model\Segurado','segurado_id','id');
    }
    public function parceiro()
    {
        return $this->belongsTo('App\Model\Parceiros','idparceiro','idparceiro');
    }

    public function proposta()
    {
        return $this->hasOne('App\Model\Propostas','idcotacao','idcotacao');
    }
    
    public function produtos()
    {
        return $this->hasMany('App\Model\CotacaoProdutos','idcotacao','idcotacao');
    }
    
    public function status(){
        return $this->belongsTo('App\Model\Status','idstatus','id');

    }

    public function usuario(){
        return $this->belongsTo('App\User','usuario_id','id');

    }

    public function tipo()
    {
        return $this->belongsTo(TipoVeiculos::class,'tipo_veiculo_id','idtipoveiculo');
    }


    public function combustivel()
    {
        return $this->belongsTo('App\Model\Combustivel', 'combustivel_id', 'id_auto_comb');
    }
    

}
