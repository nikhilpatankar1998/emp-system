<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeLog extends Model
{
    use HasFactory;
    protected $table = 'time_log';
    protected $fillable = [
        'chek_in_time',
        'user_id',
        'status',
        'in_description',
        'check_out_time',
        'out_description',
        'paused_time'
    ];
}
