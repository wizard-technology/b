<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SocialMedia extends Model
{
    public function admin()
    {
        return $this->belongsTo(User::class, 'sm_admin');
    }
}
