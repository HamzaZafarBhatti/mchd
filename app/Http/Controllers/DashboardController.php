<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Project;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __construct(){}

    public function index(){

        $user = auth()->user();
        if ($user && $user->allowed == 0){
            if ($user->is_new == 0){
                $msg = "<p>Registered Successfully.</p><p>Please wait until you are allowed by admin.</p>";
                $user->is_new = 1;
                $user->save();
            }else
                $msg = "<p>You are not allowed by admin.</p><p>Please wait until you are allowed by admin.</p>";
            auth()->logout();
            return redirect()->back()->with('error', $msg);
        }

        return redirect('/dashboard/1');
//        $departments = Department::all();
//        $data = array(
//            'departments' => [],
//            'approved' => [],
//            'unapproved' => [],
//            'total' => []
//        );
//
//        foreach ($departments as $item){
//            $data['departments'][] = $item->name;
//            $data['approved'][] = $item->users->where('allowed', 1)->count();
//            $data['unapproved'][] = $item->users->where('allowed', 0)->count();
//            $data['total'][] = $item->users->count();
//         }
//        return view('dashboard-projects', compact( 'departments', 'data'));
    }



    public function dashboard($id){
        $department = Department::findOrFail($id);
        $department_code = $department->code;
        $year = Carbon::now()->year;
        $month = Carbon::now()->month;

        $object = new Project();
        $object_name = "Projects";
        if ($department->code != 1){
            $object = new Task();
            $object_name = "Tasks";
        }

        // dashboard data
        $projects_by_status = $object::select(DB::raw('count(status) as status_count, status'))
            ->where('department_code', $department_code)
            ->whereYear('status_change_date', $year)
            ->whereMonth('status_change_date', $month)
            ->groupBy('status')->get();
        $monthly = [];
        foreach (config('constants.project_status') as $key => $value){
            $monthly[$key] = 0;
        }
        foreach ($projects_by_status as $a)
        {
            $monthly[$a->status] = $a->status_count;
            $monthly['all'] += $a->status_count;
        }


        $status_by_year = $object::select(DB::raw('count(status) as status_count, status'))
            ->where('department_code', $department_code)
            ->whereYear('status_change_date', $year)->groupBy('status')->get();
        $yearly = [];
        foreach (config('constants.project_status') as $key => $value){
            $yearly[$key] = 0;
        }
        foreach ($status_by_year as $a)
        {
            $yearly[$a->status] = $a->status_count;
            $yearly['all'] += $a->status_count;
        }


        $m12 = $object::select(DB::raw('count(status) as status_count'), 'status',
            DB::raw('YEAR(status_change_date) year, MONTH(status_change_date) month'))
            ->where('department_code', $department_code)
            ->whereYear('status_change_date', $year)
            ->groupby('status','month', 'year')->get();

        $month12 = array(
            'pending' => [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
            'inprogress' => [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
            'completed' => [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
            'notyetstarted' => [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
            'overdue' => [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
            'cancelled' => [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
        );

        foreach ($m12 as $item){
            $status = $item['status'];
            $i = $item['month'] - 1;
            $month12[$status][$i] = $item['status_count'];
        }

        return view('dashboard', compact('department', 'monthly', 'yearly','month12', 'object_name'));
    }
}
