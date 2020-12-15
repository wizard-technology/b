<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**P
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function cart()
    {
        return $this->hasMany(Cart::class, 'c_user')->orderBy('c_state');
    }
    public function admin()
    {
        return $this->hasOne(Admin::class, 'a_user');
    }
    public function city()
    {
        return $this->belongsTo(City::class, 'u_city');
    }
    public function company()
    {
        return $this->hasOne(Company::class, 'co_user');
    }
    public function logger()
    {
        return $this->hasMany(Logger::class, 'log_admin');
    }
    public function product()
    {
        return $this->hasMany(Productcompany::class, 'pc_company');
    }
  
}
