<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bizzpayment extends Model
{
    public function admin()
    {
        return $this->belongsTo(User::class, 'bz_admin');
    }

}
