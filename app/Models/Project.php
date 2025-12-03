<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $table = 'projects';
    

    protected $fillable = [
        
        'name',
        'client_id',
        'start_date',
        'end_date',
        'status',
        'server_url',
        'client_url',
        'document',
        'description',
        'employees'
    
    ];
    
}
