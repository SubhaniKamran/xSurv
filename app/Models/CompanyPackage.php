<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyPackage extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'package_id',
        'package_name',
        'package_price',
        'package_duration',
        'start_date',
        'end_date',
        'invoice_status',
        'active_status',
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}
