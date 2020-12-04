<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grouped extends Model
{
    public function admin()
    {
        return $this->belongsTo(User::class, 'gr_admin');
    }
    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class, 'gr_subcategory');
    }
}
