<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class HomePage extends Model
{
    protected $table = 'homepage_textos';
    protected $fillable = ["title", "text", "type",'status_id','order_li'];

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

}
