<?php

namespace App\Http\Controllers;

use App\Models\KPI;
use App\Models\KpiData;
use App\Models\KpiGroup;
use App\Models\KpiUnit;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class KpiSettingController extends BaseController
{
    protected function validator(array $data, $type){
        if ($type == 1)
            $table = "kpi_groups";
        else
            $table = "kpi_units";

        return Validator::make($data, [
            'name' => ['required', 'unique:'.$table],
        ], [
            'required' => 'The :attribute field is required.',
            'unique' => 'The :attribute already exists.',
        ])->validate();
    }

    public function setting(){
        $groups = KpiGroup::all()->sortBy("name");
        $units = KpiUnit::all()->sortBy("name");
        return view('admin.kpi.setting', compact('groups', 'units'));
    }

    public function add_group(Request $request){
        $this->validator($request->all(), 1);
        KpiGroup::create(['name' => $request->name]);
        return back()->with('success', "Added successfully");
    }

    public function edit_gu(Request $request){
        $type = $request->type;
        $this->validator($request->all(), $type);
        $name = $request->name;
        $id = $request->id;
        if ($type == 1){
            KpiGroup::findOrFail( $id)->update(['name' => $name]);
        }else{
            KpiUnit::findOrFail($id)->update(['name' => $name]);
        }
        return back()->with('success', 'Updated successfully');
    }

    public function delete_gu(Request $request){
        $id = $request->id;
        $type = $request->type;
        if ($type == 1){
            KpiGroup::findOrFail($id)->delete();
        }else{
            KpiUnit::findOrFail($id)->delete();
        }
        return back()->with('success', 'Deleted successfully');
    }

    public function add_unit(Request $request){
        $this->validator($request->all(), 2);
        KpiUnit::create(['name' => $request->name]);
        return back()->with('success', "Added successfully");
    }

    public function kpi_list(){
        $kpis = KPI::paginate(10);
        $groups = KpiGroup::all()->sortBy("name");
        $units = KpiUnit::all();
        return view('admin.kpi.list', compact('kpis', 'groups', 'units'));
    }

    public function add_kpi(Request $request){
        KPI::create($request->except('_token'));
        return back()->with('success', "Added Successfully.");
    }

    public function delete_kpi(Request $request){
        KPI::findOrFail($request->id)->delete();
        return back()->with('success', "Deleted Successfully.");
    }

    public function edit_kpi(Request $request){
        KPI::findOrFail($request->id)->update($request->except('_token'));
        return back()->with('success', "Edited Successfully.");
    }

    public function add_kpi_data(){
        return view('admin.kpi.add_kpi_data');
    }

    public function get_kpi_data(Request $request){
        $year = $request->year ?? Carbon::now()->year;
        $type = $request->type ?? 1;
        $groups = KpiGroup::all();
        $group_id = $request->group_id ?? -1;
        $user = auth()->user();

        if ($user->role == 2){ // super admin
            if ($group_id < 0){
                $kpis = KPI::all();
            }else{
                $kpis = KPI::where("group_id", $group_id)->get();
            }
        }else
            if ($group_id < 0){
                $kpis = KPI::findOrFail($user->assignedKpis->pluck('kpi_id'));
            }else{
                $kpis = KPI::where("group_id", $group_id)->find($user->assignedKpis->pluck('kpi_id'));
            }

        $view = view('admin.kpi.partial_kpi_data', compact('kpis', 'year', 'type', 'groups', 'group_id'));
        return $view;
    }

    public function update_kpi_data(Request $request){
        $year = $request->year;
        $type = $request->type;
        $data = $request->data;
        $kpi_id = $data[12];

        $kpi_data = KpiData::firstOrCreate(['year' => $year, "type" => $type, "kpi_id" => $kpi_id]);
        $kpi_data->update(["jan" => $data[0], "feb" => $data[1], "mar" => $data[2], "apr" => $data[3],
            "may" => $data[4], "jun" => $data[5], "jul" => $data[6], "aug" => $data[7], "sep" => $data[8],
            "oct" => $data[9], "nov" => $data[10], "dec" => $data[11]]);

        return response()->json("success", 200);
    }



    public function update_kpi_chart(Request $request){
        $year = $request->year ?? Carbon::now()->year;
        $group_id = $request->group_id ?? KpiGroup::fistItemId();
        $kpi_id = $request->kpi_id ?? KPI::firstItemInSpecGroup($group_id);
        $year_cnt = $request->year_cnt ?? 3;
        $month = $request->month ?? Carbon::now()->month;
        $previous_year = $year - 1;
        $actual = 1; $target = 2;


        $previous_year_dara_arr = KpiData::getPreviousYearDaraArr($year, $kpi_id, $actual, $year_cnt);
        $sum_years = array();
        $years = array();
        $average = array(null, null, null, null, null, 0, 0, 0, 0, 0, null, null);


        for ($i = 0; $i < $year_cnt; $i++ ){
            $temp = $year - $i - 1;
            array_push($years, $temp);
        }


        for ($i = 0; $i < count($previous_year_dara_arr); $i++){
            $sum = 0;
            for ($j = 0; $j < count($previous_year_dara_arr[$i]); $j++){
                $average[$j] += round($previous_year_dara_arr[$i][$j] / $year_cnt, 2);
                if ($j < $month){
                    $sum += $previous_year_dara_arr[$i][$j];
                }
            }
            array_push($sum_years, $sum);
        }

        $previous_year_actual = KpiData::getKpiMonthDataArrayByYearKpi_idType($previous_year, $kpi_id, $actual);
        $actual = KpiData::getKpiMonthDataArrayByYearKpi_idType($year, $kpi_id, $actual);
        $target = KpiData::getKpiMonthDataArrayByYearKpi_idType($year, $kpi_id, $target);
        $unit = KPI::getUnit($kpi_id);



        array_push($years, $year);
        $sum = 0;
        for ($i = 0; $i < count($actual); $i++){
            if ($i < $month){
                $sum += $actual[$i];
            }
        }
        array_push($sum_years, $sum);


        $groups = KpiGroup::all()->sortByDesc('id');
        $group = KpiGroup::findOrFail($group_id);
        return view("admin.kpi.partial_chart", compact("previous_year_actual", "actual",
            "target", "year", "unit", "kpi_id", "groups", "group", "previous_year_dara_arr", "year_cnt", "average",
            "year_cnt", "sum_years", "years", "month"));
    }

    public function charts(){
        return view("admin.kpi.charts");
    }

}
