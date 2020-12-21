<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RedeemCode extends Model
{
    public function company()
    {
        return $this->belongsTo(User::class, 'rc_company');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'rc_user');
    }
}
