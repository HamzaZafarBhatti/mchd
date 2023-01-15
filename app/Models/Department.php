<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    public function users(){
        return $this->hasMany(User::class, 'department_code', 'code');
    }

    public function bigprojects(){
        return $this->hasMany(BigProject::class, 'department_code', 'code');
    }

    public function projects(){
        return $this->hasMany(Project::class, 'department_code', 'code');
    }

    public function tasks(){
        return $this->hasMany(Task::class, 'department_code', 'code');
    }

    public function subtasks(){
        return $this->hasMany(SubTask::class, 'department_code', 'code');
    }
}
