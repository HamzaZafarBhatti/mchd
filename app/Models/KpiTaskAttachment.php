<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KpiTaskAttachment extends Model
{
    use HasFactory;

    protected $fillable = ['task_id', 'path_name', 'real_name', 'file_size'];
}
