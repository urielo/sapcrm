<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TipoVeiculos extends Model
{

    protected $table = 'tipoveiculo';
    protected $primaryKey = 'idtipoveiculo';
    protected $fillable = ['desc', 'idtipoveiculo'];
    public $timestamps = FALSE;
    public $incrementing = false;

    
}
