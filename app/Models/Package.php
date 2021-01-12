<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;
    protected $fillable = [
        'package_name',
        'description',
        'price',
        'duration',
        'status',
        'recommend_status',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
