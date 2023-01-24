<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationUser extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'user_id','notification_id','is_read'
    ];
}
