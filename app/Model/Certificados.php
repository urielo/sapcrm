<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Certificados extends Model
{
    protected $table = 'certificados';
    protected $fillable = [
        'idproposta',
        'idseguradora',
        'dt_emissao',
        'dt_inicio_virgencia',
        'iof',
        'pdf_base64',
    ];

    public $timestamps = FALSE;


    public function custos()
    {
        return $this->belongsToMany(CustoProduto::class, 'certificado_custo','certificado_id','custo_produto_id');
    }
}
