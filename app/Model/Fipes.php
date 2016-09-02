<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Fipes extends Model
{

    protected $table = 'fipe';
    protected $primaryKey = 'codefipe';
    protected $fillable = ["marca", "codefipe", "modelo",'idstatus'];
    public $incrementing = false;

    public function anovalor()
    {
        return $this->hasMany('App\Model\FipeAnoValor', 'codefipe', 'codefipe');
    }
    
    public function status(){
        return $this->belongsTo('App\Model\Status','idstatus','id');
            
    }
}
