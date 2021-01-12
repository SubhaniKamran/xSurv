<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyDates extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'date1',
        'date2',
        'date3',
        'date4',
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}
