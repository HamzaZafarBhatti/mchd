<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'big_project_id',
        'object_id',
        'user_id',
        'object_type',
        'action_type',
        'data'
    ];
}
