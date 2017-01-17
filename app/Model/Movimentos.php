<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Movimentos extends Model
{
    protected $table = 'movimento_certificado';
    protected $fillable = [
        'datas_enviadas',
        'datas_recebidas',
        'dt_envio',
        'dt_retorno',
        'tipo_envio',
        'status_id',
    ];
    public $timestamps = false;
}
