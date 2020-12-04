<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producttag extends Model
{
    public function tagName()
    {
        return $this->belongsTo(Tag::class ,'pt_tag')->where('tg_state',1);
    }
    public function product()
    {
        return $this->belongsTo(Product::class, 'pt_product')->where('p_state',1);
    }
}
