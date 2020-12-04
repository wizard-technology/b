<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function tags()
    {
        return $this->hasMany(Producttag::class, 'pt_product');
    }
    public function type()
    {
        return $this->belongsTo(Type::class, 'p_type');
    }
    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class, 'p_subcategory');
    }
    public function grouped()
    {
        return $this->belongsTo(Grouped::class, 'p_grouped');
    }
    public function card()
    {
        return $this->hasOne(Cardinfo::class, 'ci_product');
    }
    public function favorate()
    {
        return $this->hasMany(Favorite::class, 'fa_product');
    }
    public function cart()
    {
        return $this->hasMany(Cart::class, 'c_product');
    }
    public function admin()
    {
        return $this->belongsTo(User::class, 'p_admin');
    }
}
