<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Corretores extends Model
{

    protected $table = 'corretor';
    protected $primaryKey = 'idcorretor';
    protected $fillable = [
        'corresusep',
        'corrcpfcnpj',
        'corrnomerazao',
        'corrdtnasc',
        'corrcdsexo',
        'corrcdestadocivil',
        'corrcdprofiramoatividade',
        'corremail',
        'corrdddcel',
        'corrnmcel',
        'corrdddfone',
        'corrnmfone',
        'corrnmend',
        'corrnumero',
        'correndcomplet',
        'corrcep',
        'corrnmcidade',
        'corrcduf',
        'idstatus',
        'corrcomissaopadrao',
        'idcorretor',
        'idparceiro'
    ];
    public $timestamps = FALSE;

    public function cotacoes()
    {
        return $this->hasMany('App\Model\Cotacoes', 'idcorretor','idcorretor');
    }
}
