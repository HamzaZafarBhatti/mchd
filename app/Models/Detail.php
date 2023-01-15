<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detail extends Model
{
    use HasFactory;
    protected $table = "details";
    protected $fillable = ['user_id', 'department_code', 'type'];
    public $timestamps = false;

    public function department(){
        return $this->belongsTo(Department::class, 'department_code', 'code');
    }
}
