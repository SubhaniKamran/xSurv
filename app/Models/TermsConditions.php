<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TermsConditions extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'termscondition',
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}
