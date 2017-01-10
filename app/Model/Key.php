<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Key extends Model
{
    protected $table = 'keys';
    public $timestamps = false;
    protected  $fillable = [
        'id',
        'user_id',
        'key',
        'level',
        'ignore_limits',
        'is_private_key',
        'ip_addresses',
        'date_created',
    ];
}
