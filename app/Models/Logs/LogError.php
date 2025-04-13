<?php

namespace App\Models\Logs;

use Illuminate\Database\Eloquent\Factories\HasFactory;


class LogError extends Log
{
    use HasFactory;

    protected $fillable = [
        'created_user_id',
        'message',
        'request',
        'status',
        'body',
        'params',
        'trace',
        'ip',
        'browser',
        'so'
    ]; 
}
