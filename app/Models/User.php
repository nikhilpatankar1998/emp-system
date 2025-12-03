<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Carbon\Carbon;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'department',
        'date_of_joining',
        'date_of_birth',
        'role'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
  
       public function timeLogs()
{
    return $this->hasMany(TimeLog::class);
}

public function timeLogsToday()
{
    return $this->hasMany(TimeLog::class)->whereDate('created_at', Carbon::today());
}

public function timeLogsThisMonth()
{
    return $this->hasMany(TimeLog::class, 'user_id')
        ->whereBetween('created_at', [now()->startOfMonth(), now()->endOfDay()]);
}
public function leavesThisMonth()
{
    $startOfMonth = Carbon::now()->startOfMonth();
    $today = Carbon::today();

    return $this->hasMany(Leave::class)->where('status', 'approved')->where(function ($q) use ($startOfMonth, $today) {
        $q->whereBetween('from_date', [$startOfMonth, $today])
            ->orWhereBetween('to_date', [$startOfMonth, $today])
            ->orWhere(function ($q2) use ($startOfMonth, $today) {
                $q2->where('from_date', '<=', $startOfMonth)
                    ->where('to_date', '>=', $today);
            });
    });
}
}
