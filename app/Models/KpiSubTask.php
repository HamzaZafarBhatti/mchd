<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class KpiSubTask extends Model
{
    use HasFactory, Sortable;

    public $sortable = ['name', 'status', 'end_date'];

    protected $fillable = ['task_id', 'leader_id', 'name', 'description', 'status', 'start_date', 'end_date', 'department_code', 'status_change_date'];

    public function department(){
        return $this->belongsTo(Department::class, 'department_code', 'code');
    }

    public function attachments(){
        return $this->hasMany(KpiSubTaskAttachment::class, 'sub_id', 'id');
    }

    public function task(){
        return $this->belongsTo(KpiTask::class, 'task_id', 'id');
    }

    public function leader(){
        return $this->belongsTo(User::class, 'leader_id', 'id');
    }

    public function assignUsers(){
        return $this->belongsToMany(User::class, 'kpi_sub_task_assignees', 'sub_task_id', 'user_id')
            ->where('allowed', 1);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable')->latest();
    }
}
