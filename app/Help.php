<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Help extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class, 'h_user');
    }
}
