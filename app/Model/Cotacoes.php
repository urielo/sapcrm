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
    ];
    public $timestamps = FALSE;
    
    public function veiculo()
    {
        return $this->belongsTo('App\Model\Veiculos','veicid','veicid');
    }
    
    public function corretor()
    {
        
    }
    public function segurado()
    {
        
    }
    public function parceiro()
    {
        
    }

}
