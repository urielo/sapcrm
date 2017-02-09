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
        "veianofab",
    ];
    public $timestamps = FALSE;

    public function segurado()
    {
        return $this->belongsTo('App\Model\Segurado', 'clicpfcnpj', 'clicpfcnpj');
    }

    public function fipe()
    {
        return $this->belongsTo('App\Model\Fipes', 'veiccodfipe', 'codefipe');
    }

    /**
     * @return array
     */

    public function tipo()
    {
        return $this->belongsTo(TipoVeiculos::class,'veiccdveitipo','idtipoveiculo');
    }


    public function combustivel()
    {
        return $this->belongsTo('App\Model\Combustivel', 'veictipocombus', 'id_auto_comb');
    }

    public function fipe_ano_valor()
    {
        return $this->hasMany('App\Model\FipeAnoValor', 'codefipe', 'veiccodfipe');
    }
}
