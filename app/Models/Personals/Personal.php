<?php

namespace App\Models\Personals;

use App\Models\Orders\Order;
use App\Models\Services\Service;
use Illuminate\Database\Eloquent\Model;

class Personal extends Model
{
    protected $guarded =[];

    public function services()
    {
        return $this->belongsToMany(Service::class)->withPivot(['personal_chosen_status','personal_confirmed_services']);
    }

    public function order()
    {
        return $this->belongsToMany(Order::class);
    }
}
