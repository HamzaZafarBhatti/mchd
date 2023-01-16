<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Kyslik\ColumnSortable\Sortable;

class KpiTask extends Model
{
    use HasFactory, Sortable;

    public $sortable = ['name', 'status', 'end_date'];

    protected $fillable = [
        'project_id', 'leader_id', 'name', 'description', 'status', 'priority', 'start_date', 'end_date', 'assignee',
        'assignee_names', 'project_name', 'leader_name', 'department_code', 'status_change_date'
    ];

    public function assignUsers(){
        return $this->belongsToMany(User::class, 'kpi_task_assignees', 'task_id', 'user_id')
            ->where('allowed', 1);
    }

    public function project(){
        return $this->belongsTo(KpiProject::class, 'project_id', 'id');
    }

    public function leader(){
        return $this->belongsTo(User::class, 'leader_id', 'id');
    }

    public function subTasks(){
        return $this->hasMany(KpiSubTask::class, 'task_id', 'id')
            ->select(["*", DB::raw( 'DATEDIFF(end_date, start_date) as period')])->orderBy('id', 'desc');
    }

    public function department(){
        return $this->belongsTo(Department::class, 'department_code', 'code');
    }

    public function attachments(){
        return $this->hasMany(KpiTaskAttachment::class, 'task_id', 'id');
    }
}
