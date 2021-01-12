<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Profile extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = [];
    protected $dates = ['deleted_at'];
    public function getRouteKeyName()
    {
      return 'id';
    }
    public function users(){
      return $this->belongsTo("App\Models\user");
    }
    protected $fillable = [
        'user_id',
        'full_name',
        'address',
        'phone',
        'image',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
