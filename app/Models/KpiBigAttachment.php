<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KpiBigAttachment extends Model
{
    use HasFactory;
    protected $fillable = ['big_id', 'path_name', 'real_name', 'file_size'];
}
