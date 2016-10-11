<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Veiculos extends Model
{

    protected $table = 'veiculosegurado';
    protected $primaryKey = 'veicid';
    protected $fillable = [
        "veiccodfipe",
        "veicano",
        "veicautozero",
        "veiccdutilizaco",
        "veiccdveitipo",
        "veictipocombus",
        "veicplaca",
        "veicmunicplaca",
        "veiccdufplaca",
        "veicrenavam",
        "veicanorenavam",
        "veicchassi",
        "veicchassiremar",
        "veicleilao",
        "veicalienado",
        "veicacidentado",
        "clicpfcnpj",
        "propcpfcnpj",
        "condcpfcnpj",
        "idstatus",
        "dtcreate",
        "dtupdate",
        "veicor",
    ];
    public $timestamps = FALSE;

    public function segurado()
    {
        return $this->belongsTo('App\Model\Segurado','clicpfcnpj','clicpfcnpj');
    }

    public function fipe()
    {
        return $this->belongsTo('App\Model\Fipes','veiccodfipe', 'codefipe');
    }
    
    public function combustivel()
    {
        return $this->belongsTo('App\Model\Combustivel','veictipocombus', 'id_auto_comb');
    }
    
}
