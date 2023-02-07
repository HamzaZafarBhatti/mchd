<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Kyslik\ColumnSortable\Sortable;

class Project extends Model
{
    use HasFactory, Sortable;

    protected $fillable = ['big_project_id', 'leader_id', 'name', 'description', 'start_date',
        'end_date', 'status', 'leader_name', 'assignee', 'assignee_names', 'status_change_date',
        'attach_origin_name', 'attach_path', 'department_code'];
    public $sortable = ['name', 'status', 'end_date'];

    public static function getProjectsByStatusWithPagination($status, $cnt){
        if ($status === "all"){
            $projects = Project::sortable()->paginate($cnt);
        }else
            $projects = Project::where('status', $status)->sortable()->paginate($cnt);

        return $projects;
    }


    public function user(){
        return $this->belongsTo(User::class, 'leader_id', 'id');
    }

    public function assignUsers(){
        return $this->belongsToMany(User::class, 'project_assignees', 'project_id', 'user_id')
            ->where('allowed', 1);
    }
    public function assignLeaders(){
        return $this->belongsToMany(User::class, 'project_leaders', 'project_id', 'leader_id')
            ->where('allowed', 1);
    }

    public function tasks(){
        return $this->hasMany(Task::class, 'project_id', 'id')
            ->select(["*", DB::raw( 'DATEDIFF(end_date, start_date) as period')])->orderBy('id', 'desc');
    }

    public function department(){
        return $this->belongsTo(Department::class, 'department_code', 'code');
    }

    public function attachments(){
        return $this->hasMany(ProAttachment::class, 'pro_id', 'id');
    }

    public function big_project(){
        return $this->belongsTo(BigProject::class, 'big_project_id', 'id');
    }
}
