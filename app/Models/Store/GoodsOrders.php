<?php

namespace App\Models\Store;

use Illuminate\Database\Eloquent\Model;
use App\Models\Cunsomers\Cunsomer;

class GoodsOrders extends Model
{
    public function images()
    {
        return $this->hasMany(GoodsOrdersImages::class);
    }

    public function statuses()
    {
        return $this->hasOne(GoodsOrdersStatuses::class);
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function cunsomer()
    {
        return $this->belongsTo(Cunsomer::class);
    }
}
