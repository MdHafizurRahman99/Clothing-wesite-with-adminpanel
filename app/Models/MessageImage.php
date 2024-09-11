<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessageImage extends Model
{
    use HasFactory;
    protected $fillable = [
        'message_id',
        'thread_id',
        'image_url',
    ];
}
