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
        'idparceiro',
        'corrcomissaomin'
    ];
    public $timestamps = FALSE;

    public function cotacoes()
    {
        return $this->hasMany('App\Model\Cotacoes', 'idcorretor','idcorretor');
    }
    public function parceiro()
    {
        return $this->belongsTo('App\Model\Parceiros', 'idparceiro','idparceiro');
    }
    public function usuarios()
    {
        return $this->hasMany('App\User', 'idcorretor','idcorretor');
    }

    public function estadocivil()
    {
        return $this->belongsTo('App\Model\EstadosCivis', 'corrcdestadocivil', 'idestadocivil');
    }


    public function uf()
    {
        return $this->belongsTo('App\Model\Uf', 'corrcduf', 'cd_uf');

    }
}

