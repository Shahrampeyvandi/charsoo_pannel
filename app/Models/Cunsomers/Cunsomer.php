<?php

namespace App\Models\Cunsomers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Models\Acounting\UserAcounts;
use App\Models\User;

class Cunsomer extends  Authenticatable  implements JWTSubject
{
    protected $guarded = [];
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function useracounts()
    {
        return $this->hasMany(UserAcounts::class);
    }

    public function broker()
    {
        return $this->belongsToMany(User::class);
    }
}
