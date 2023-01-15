<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignedKpi extends Model
{
    use HasFactory;
    protected $table = "kpi_assigned_kpis";
    protected $fillable = ["user_id", "kpi_id"];
    public $timestamps = false;
}
