<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    use HasFactory;
    protected $table = 'leave_record';
    protected $fillable = [
        'user_id',
        'from_date',
        'to_date',
        'reason',
        'leave_type',
        'status',
        'leave_duration'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
