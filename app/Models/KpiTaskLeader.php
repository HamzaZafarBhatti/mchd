<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KpiTaskLeader extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['task_id', 'project_id', 'leader_id'];
}
