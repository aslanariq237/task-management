<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Employee extends Model
{
    use HasRoles;
    protected $table = 'employees';
    protected $fillable = [
        'code',
        'name',
        'email'
    ];    
}
