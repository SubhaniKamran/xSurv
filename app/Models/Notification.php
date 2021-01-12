<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    protected $fillable = [
        'message',
        'sender_id',
        'reciever_id',
        'status',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
