<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $table  = 'tasks';

    protected $fillable = [
        'title',
        'project_id',
        'description',
        'assigned_to',
        'task_date'
    ];

    public function project() {
        return $this->belongsTo(Project::class, 'project_id');
    }
    
    public function user() {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}
