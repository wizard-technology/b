<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    public function admin()
    {
        return $this->belongsTo(User::class, 'ct_admin');
    }

}
