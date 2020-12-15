<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    public function product()
    {
        return $this->belongsTo(Product::class, 'c_product');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'c_user');
    }
}
