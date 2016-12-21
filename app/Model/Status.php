<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $table = 'status';
    protected $primaryKey = 'id';
    public $timestamps = FALSE;
    protected $fillable = [

        'id',
        'descricao',
        

    ];
}
