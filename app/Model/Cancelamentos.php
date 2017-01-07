<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Cancelamentos extends Model
{
    protected $table = 'cancelamentos';
    protected $fillable = ['cancelado_id', 'cancelado_desc', 'motivo_id',];

    public function motivo()
    {
        return $this->belongsTo(Motivos::class, 'motivo_id', 'id');
    }

    public function proposta()
    {
        return $this->belongsTo(Propostas::class, 'cancelado_id', 'idproposta');
    }


}
