<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    public function items()
    {
        return $this->belongsToMany(Tag::class)
            ->orderBy('tags.name');
    }
}
