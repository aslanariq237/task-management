<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $table = 'projects';
    protected $fillable = [
        'employee_id',
        'code',
        'name',
        'description',
        'status',
        'started_at',
        'ended_at'
    ];
    protected $casts = [
        'started_at' => 'date',
        'ended_at'  => 'date'
    ];

    public function projectMember(){
        return $this->hasMany(ProjectMember::class);
    }        
}
