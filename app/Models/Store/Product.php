<?php

namespace App\Models\Store;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = [];
    
    public function store()
    {
        return $this->hasOne(Store::class);
    }
}
