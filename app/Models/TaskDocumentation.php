<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskDocumentation extends Model
{
    protected $table = 'task_documentations';
    protected $fillable = [
        'project_id',
        'employee_id',
        'task_id',
        'image_url',
        'type',
        'location',
        'taken_at'
    ];

    protected $casts = [
        'taken_at' => 'date'
    ];
}
