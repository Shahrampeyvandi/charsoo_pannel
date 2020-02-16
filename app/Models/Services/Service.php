<?php

namespace App\Models\Services;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $guarded =[];

    public function relationCategory()
    {
        return $this->belongsTo(ServiceCategory::class,'service_category_id','id');
    }

    public function relatedBroker()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
}
