<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BigProjectManager extends Model
{
    use HasFactory;

    
    public $timestamps = false;
    protected $fillable = ["big_project_id", "manager_id"];
}
