<?php

namespace App\Models\Personals;

use App\Models\Orders\Order;
use App\Models\Services\Service;
use App\Models\Personals\Position;
use App\Models\Acounting\UserAcounts;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Personal  extends  Authenticatable  implements JWTSubject
{
    protected $guarded = [];
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        return [
            'first_name'      => $this->personal_firstname,
            'last_name'       => $this->personal_lastname,
            'mobile'           => $this->personal_mobile,
        ];
    }


    public function services()
    {
        return $this->belongsToMany(Service::class)->withPivot(['personal_chosen_status','personal_confirmed_services']);
    }

    public function order()
    {
        return $this->belongsToMany(Order::class);
    }
	
	  public function positions()
    {
        return $this->hasMany(Position::class);
    }

    public function useracounts()
    {
        return $this->hasMany(UserAcounts::class);
    }
}
