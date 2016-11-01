<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Segurado extends Model
{

    protected $table = 'segurado';
    protected $primaryKey = 'clicpfcnpj';
    protected $fillable = [
        "clicpfcnpj",
        "clinomerazao",
        "clidtnasc",
        "clicdsexo",
        "clicdestadocivil",
        "clicdprofiramoatividade",
        "cliemail",
        "clidddcel",
        "clinmcel",
        "clidddfone",
        "clinmfone",
        "clinumero",
        "cliendcomplet",
        "clicep",
        "clinmcidade",
        "clicduf",
        "idstatus",
        "dtcreate",
        "dtupdate",
        'clinumrg',
        'clidtemissaorg',
        'clicdufemissaorg',
        'cliemissorrg',
        'clinmend',
        'bairro',
    ];
    public $timestamps = FALSE;
    public $incrementing = false;

    public function veiculo()
    {
        return $this->hasMany('App\Model\Veiculos');
    }

    /**
     * @return string
     */
    public function estadocivil()
    {
        return $this->belongsTo('App\Model\EstadosCivis', 'clicdestadocivil', 'idestadocivil');
    }

    public function profissao()
    {
        return $this->belongsTo('App\Model\Profissoes', 'clicdprofiramoatividade' , 'id_ocupacao');

    }


    public function ramosatividade()
    {
        return $this->belongsTo('App\Model\RamoAtividades', 'clicdprofiramoatividade', 'id_ramo_atividade');

    }
    public function uf()
    {
        return $this->belongsTo('App\Model\Uf', 'clicduf', 'cd_uf');

    }
    
    public function rguf()
    {
        return $this->belongsTo('App\Model\Uf', 'clicdufemissaorg', 'cd_uf');

    }

}
