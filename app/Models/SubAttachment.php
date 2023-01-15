<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubAttachment extends Model
{
    use HasFactory;
    protected $fillable = ['sub_id', 'path_name', 'real_name', 'file_size'];
}
