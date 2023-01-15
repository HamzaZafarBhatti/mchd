<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KPI extends Model
{
    use HasFactory;
    protected $table = "kpi_kpis";
    protected $fillable = ['group_id', 'criteria', 'unit_id', 'description'];

    public function group(){
        return $this->hasOne(KpiGroup::class, 'id', 'group_id');
    }

    public function unit(){
        return $this->hasOne(KpiUnit::class, 'id', 'unit_id');
    }

    public function data($year, $type) //1: actual, 2: target, 3: actual_cumulative, 4: target_cumulative
    {
        return $this->hasMany(KpiData::class, 'kpi_id', 'id')
            ->where("type", $type)
            ->where("year", $year)
            ->first();
    }

    public static function getUnit($kpi_id){
        $unit = "";
        $kpi = KPI::find($kpi_id);
        if ($kpi)
            $unit = $kpi->unit->name;
        return $unit;
    }

    public static function fistItemId(){
        $id = 0;
        $first = KPI::first();
        if ($first)
            $id = $first->id;
        return $id;
    }

    public static function firstItemInSpecGroup($group_id){
        $id = 0;
        $first = KPI::where("group_id", $group_id)->first();
        if ($first)
            $id = $first->id;
        return $id;
    }
}
