<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'month',
        'year',
        'basic_salary',
        'other_allowances',
        'incentive_pay',
        'provident_fund',
        'professional_tax',
        'other_deduction',
        'total_allowances',
        'total_deduction',
        'net_salary',
    ];

     public function user()
    {
        return $this->belongsTo(User::class);
    }
}
