<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Kyslik\ColumnSortable\Sortable;
use Laravel\Sanctum\HasApiTokens;
use phpDocumentor\Reflection\Types\This;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Sortable;

    public $sortable = ['name', 'role'];

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
        'role',
        'allowed',
        'boss',
        'department_code',
        'fcm_token'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function getUserByName($name){
        return User::where('name', $name)->first();
    }

    public function tasks(){
        return $this->belongsToMany(Task::class, 'task_assignees', 'user_id', 'task_id');
    }

    public function kpi_tasks(){
        return $this->belongsToMany(KpiTask::class, 'kpi_task_assignees', 'user_id', 'task_id');
    }


    public function department(){
        return $this->belongsTo(Department::class, 'department_code', 'code');
    }

    public static function members($code){
        return User::where('department_code', $code)->where('allowed', 1)->get();
    }

    public function details(){ // for side bar menu
        return $this->hasMany(Detail::class, 'user_id', 'id')
            ->orderBy('department_code', 'asc');
    }

    public function assignedKpis(){
        return $this->hasMany(AssignedKpi::class, "user_id", "id");
    }

}
