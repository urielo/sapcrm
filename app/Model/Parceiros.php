<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Parceiros extends Model
{

    protected $table = 'parceiro';
    protected $primaryKey = 'idparceiro';
    protected $fillable = [
        'idparceiro',
        'nomerazao',
        'cpfcnpj',
        'dddfonefixoparceiro',
        'fonefixoparceiro',
        'loginwservicesap',
        'senhawservicesap',
        'ctocomercial',
        'dddfonecomercial',
        'fonecomercial',
        'contatotecnico',
        'dddfonetecnico',
        'fonetecnico',
        'loginplataforma',
        'senhaplataforma',
    ];

    public $timestamps = FALSE;

    public function corretor()
    {
        $this->hasMany('App\Model\Corretores', 'idparceiro', 'idparceiro');
    }

    public function key()
    {
        return $this->hasOne('App\Model\Key','user_id','idparceiro');
    }






}
