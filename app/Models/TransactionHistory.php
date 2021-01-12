<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionHistory extends Model
{
    use HasFactory;
    protected $fillable = [
        'company_packages_id',
        'user_id',
        'transaction_id',
        'package_id',
        'package_name',
        'package_price',
        'package_duration',
        'amount_paid',
        'end_date',
        'invoice',
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}
