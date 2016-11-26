<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class HomePage extends Model
{
    protected $table = 'homepage_textos';
    protected $fillable = ["title", "text", "type"];

}
