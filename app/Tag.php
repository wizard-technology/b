<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    public function admin()
    {
        return $this->belongsTo(User::class, 'tg_admin');
    }
}
