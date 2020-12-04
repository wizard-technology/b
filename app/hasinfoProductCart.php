<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class hasinfoProductCart extends Model
{
    public function info()
    {
        return $this->belongsTo(Cardinfo::class, 'hpc_cardinfo');
    }
    
}
