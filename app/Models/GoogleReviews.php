<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoogleReviews extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'google_url',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function user(){
        return $this->belongsTo("App\Models\user");
    }
}
