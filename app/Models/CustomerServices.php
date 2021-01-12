<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerServices extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'customer_id',
        'survey_id',
        'service_id',
        'email_date',
        'service_date',
        'survey_question',
        'survey_answer',
        'email_status',
        'reaction_status',
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}
