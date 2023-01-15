<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KpiProAttachment extends Model
{
    use HasFactory;
    protected $fillable = ['pro_id', 'path_name', 'real_name', 'file_size'];
}
