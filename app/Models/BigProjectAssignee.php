<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BigProjectAssignee extends Model
{
    use HasFactory;

    protected $fillable = ["big_project_id", "leader_id"];
}
