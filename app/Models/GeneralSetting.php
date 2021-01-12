<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneralSetting extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'logo_url',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
