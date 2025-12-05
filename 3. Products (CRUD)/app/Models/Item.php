<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'name' => 'string',
        'description' => 'string',
        'price' => 'decimal:2',
    ];
    public $timestamps = true;
}
