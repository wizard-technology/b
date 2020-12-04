<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Productcompany extends Model
{
    public function images()
    {
        return $this->hasMany(Imageproductcompany::class, 'ipc_produc');
    }
}
