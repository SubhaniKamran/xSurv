<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use HasFactory;use SoftDeletes;
    protected $guarded = [];
    protected $dates = ['deleted_at'];
    public function users()
    {
        return $this->hasMany('App\Models\User');
    }
}
