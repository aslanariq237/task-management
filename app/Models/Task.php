<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $table = 'tasks';
    protected $fillable = [
        'project_id',
        'assigned_at',
        'code',
        'name',
        'description',
        'to_do',
        'notes',
        'status',
        'started_at',
        'ended_at'
    ];

    protected $casts = [
        'started_at' => 'date',
        'ended_at'   => 'date',
    ];

    public function project(){
        return $this->hasOne(Project::class, 'id', 'project_id');
    }

    public function employee(){
        return $this->hasOne(Employee::class, 'id', 'assigned_at');
    }
}
