<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Logger extends Model
{
    protected $fillable = ['log_name', 'log_action', 'log_admin', 'log_info'];
    public function employee()
    {
        return $this->belongsTo(User::class, 'log_admin');
    }
}
