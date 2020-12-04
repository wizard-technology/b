<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    public function admin()
    {
        return $this->belongsTo(User::class, 'co_admin');
    }
  
}
