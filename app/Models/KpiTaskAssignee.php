<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KpiTaskAssignee extends Model
{
    use HasFactory;
    protected $fillable = ['task_id', 'project_id', 'user_id'];
}
