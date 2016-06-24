<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class EstadosCivis extends Model
{

    protected $table = 'estadocivil';
    protected $primaryKey = 'idestadocivil';
    protected $fillable = ['idestadocivil', 'nmestadocivil'];
    public $timestamps = FALSE;

}
