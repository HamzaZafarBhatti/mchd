<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubTaskAssignees extends Model
{
    use HasFactory;
    protected $fillable = ['sub_task_id', 'task_id', 'user_id'];
}
