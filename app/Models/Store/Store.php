<?php

namespace App\Models\Store;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    protected $guarded =[];

    protected $casts = ['store_neighborhoods' => 'array'];

    public function products()
    {
        return $this->hasMany(Product::class);

    }
}
