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
        'clicpfcnpj',
        'veicid',
        'premio',
        'comissao',
        'idstatus',
        'dtvalidade',
        'dtcreate',
        'dtupdate',
        'usuario_id',
    ];
    public $timestamps = FALSE;
    
    public function veiculo()
    {
        return $this->belongsTo('App\Model\Veiculos','veicid','veicid');
    }
    
    public function corretor()
    {
        return $this->belongsTo('App\Model\Corretores','idcorretor','idcorretor');
    }
    public function segurado()
    {
        return $this->belongsTo('App\Model\Segurado','clicpfcnpj','clicpfcnpj');
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
    

}
