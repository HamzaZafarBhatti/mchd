<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KpiData extends Model
{
    use HasFactory;
    protected $fillable = ["year", "kpi_id", "type", "jan", "feb", "mar", "apr", "may",
        "jun", "jul", "aug", "sep", "oct", "nov", "dec"];

    public static function getKpiMonthDataArrayByYearKpi_idType($year, $kpi_id, $type){
        $data = KpiData::select(["jan", "feb", "mar", "apr", "may", "jun", "jul", "aug", "sep", "oct", "nov", "dec"])
            ->where('year', $year)->where('kpi_id', $kpi_id)
            ->where('type', $type)->first();
        if (!$data)
            $data = [];
        else
            $data = $data->toArray();
        return array_values($data);
    }


    public static function getPreviousYearDaraArr($year, $kpi_id, $type, $year_cnt){
        $arr = array();
        for ($i = $year - 1; $i >= $year - $year_cnt; $i--){
            array_push($arr, self::getKpiMonthDataArrayByYearKpi_idType($i, $kpi_id, $type));
        }
        return $arr;
    }

}
