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
    ];
    public $timestamps = FALSE;

    public function segurado()
    {
        return $this->belongsTo('App\Model\Segurado');
    }
}
