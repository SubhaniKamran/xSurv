<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'template_name',
        'template_description',
        'question',
    ];

    public function user(){
        return $this->belongsTo("App\Models\user");
    }
}
