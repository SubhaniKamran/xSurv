<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'email',
        'password',
        'role_id',
        'status',
        'terms_condition',
        'stripe_customer_id',
        'stripe_card_id',
        'card_number',
        'card_exp_month',
        'card_cvc',
        'card_exp_year',
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function role()
    {
        return $this->belongsTo('App\Models\Role');
    }
    public function profile(){
        return $this->hasOne('App\Models\Profile');
    }
    public function surveys(){
        return $this->hasMany('App\Models\Survey');
    }
}
