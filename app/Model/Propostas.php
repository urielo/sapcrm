<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Propostas extends Model
{

    protected $table = 'proposta';
    protected $primaryKey = 'idproposta';
    protected $fillable = [
        'idproposta',
        'idcotacao',
        'idformapg',
        'quantparc',
        'dtvalidade',
        'dtcreate',
        'codstatus',
        'nmbandeira',
        'numcartao',
        'validadecartao',

    ];
    public $timestamps = FALSE;

    public function cotacao()
    {
        return $this->hasOne('App\Model\Cotacoes', 'idcotacao', 'idcotacao');
    }

   


}
