<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cardinfo extends Model
{
    public function product()
    {
        return $this->belongsTo(Product::class, 'ci_product');
    }
    public function admin()
    {
        return $this->belongsTo(User::class, 'ci_admin');
    }
}
