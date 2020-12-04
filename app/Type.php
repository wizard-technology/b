<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    public function admin()
    {
        return $this->belongsTo(User::class, 't_admin');
    }

}
