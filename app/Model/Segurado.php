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
        return $this->hasOne('App\Model\EstadosCivis', 'idestadocivil', 'clicdestadocivil');
    }

    public function profissao()
    {
        return $this->hasOne('App\Model\Profissoes', 'id_ocupacao', 'clicdprofiramoatividade');

    }


    public function ramosatividade()
    {
        return $this->hasOne('App\Model\RamoAtividades', 'id_ramo_atividade', 'clicdprofiramoatividade');

    }
    public function uf()
    {
        return $this->hasOne('App\Model\Uf', 'cd_uf', 'clicduf');

    }
}
