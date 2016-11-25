<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Fipes extends Model
{

    protected $table = 'fipe';
    protected $fillable = ["marca", "codefipe", "modelo",'idstatus'];
    protected $primaryKey = 'codefipe';
    public $incrementing = false;

    public function anovalor()
    {
        return $this->hasMany('App\Model\FipeAnoValor', 'codefipe', 'codefipe');
    }
    
    public function status(){
        return $this->belongsTo('App\Model\Status','idstatus','id');
            
    }
}
