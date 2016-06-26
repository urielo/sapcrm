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
    
      public function veiculo()
    {
        return $this->hasMany('App\Model\Veiculos');
    }

}
