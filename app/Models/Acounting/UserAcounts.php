<?php

namespace App\Models\Acounting;

use Illuminate\Database\Eloquent\Model;
use App\Models\Acounting\Transations;
use App\Models\Acounting\CheckoutPersonals;


class UserAcounts extends Model
{
    protected $quarded= [];

    public function transactions()
    {
        return $this->hasMany(Transations::class);
    }

    public function checkoutpersonals()
    {
        return $this->hasMany(CheckoutPersonals::class);
    }
}
