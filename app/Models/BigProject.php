<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BigProject extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'status', 'status_change_date', 'start_date', 'end_date', 'boss_id', 'department_code'];

    public function assignUsers()
    {
        return $this->belongsToMany(User::class, 'big_project_assignees', 'big_project_id', 'leader_id')
            ->where('allowed', 1);
    }
    public function assignManagers()
    {
        return $this->belongsToMany(User::class, 'big_project_managers', 'big_project_id', 'manager_id')
            ->where('allowed', 1);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable')->latest();
    }

    public function projects()
    {
        return $this->hasMany(Project::class, 'big_project_id', 'id')
            ->select(["*", DB::raw('DATEDIFF(end_date, start_date) as period')])->orderBy('id', 'desc');
    }

    public function attachments()
    {
        return $this->hasMany(BigAttachment::class, 'big_id', 'id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_code', 'code');
    }

    public function boss()
    {
        return $this->belongsTo(User::class, 'boss_id', 'id');
    }


    public function tasks($projects)
    {
        $tasks = array();
        foreach ($projects as $project) {
            foreach ($project->tasks as $task) {
                array_push($tasks, $task);
            }
        }
        return $tasks;
    }

    public function subTasks($projects)
    {
        $subTasks = array();
        foreach ($this->tasks($projects) as $task) {
            foreach ($task->subTasks as $subTask) {
                array_push($subTasks, $subTask);
            }
        }
        return $subTasks;
    }
}
