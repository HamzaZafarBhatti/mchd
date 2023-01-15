<?php

namespace App\Http\Controllers;

use App\Models\AssignedKpi;
use App\Models\Department;
use App\Models\Detail;
use App\Models\KPI;
use App\Models\User;
use Illuminate\Http\Request;
use File;


class UsermanagementController extends Controller
{
    public function usermanagement(Request $request){
        $code = $request->code;
        $sort = $request->sort;
        $direction = $request->direction;

        if (!empty($code)){
            $users = User::sortable()
                //->where('role', '<>', 2) // 2: super admin
                ->where('department_code', $code)
                ->orderBy('id', 'desc')
                ->paginate(10);
        }else{
            $users = User::sortable()
                //->where('role', '<>', 2) // 2: super admin
                ->orderBy('id', 'desc')->paginate(10);
        }
        return view('admin.usermanagement', compact('users', 'code', 'sort', 'direction'));
    }

    public function allowed(Request $request){
        $user_id = $request->id;
        $user = User::findOrFail($user_id);
        $user->allowed = $user->allowed == 0? 1: 0;
        $user->save();
        return redirect()->back();
    }

    public function setboss(Request $request){
        $user_id = $request->user_id;
        $boss = $request->role;
        User::where('id', $user_id)->update(['role' => $boss]);
        return back()->with('success', "changed successfully.");
    }

    public function remove_user(Request $request){
        $user_id = $request->user_id;
        $user = User::findOrFail($user_id);

        try {
            if($user->avatar != "user_default.jpg" && File::exists(public_path('images/'.$user->avatar))){
                File::delete(public_path('images/'.$user->avatar));
            }
        }catch (\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
        $user->delete();
        return redirect()->back()->with('success', 'Removed Successfully.');
    }

    public function chart(){

        $departments = Department::all();
        $data = array(
            'departments' => [],
            'approved' => [],
            'unapproved' => [],
            'total' => []
        );

        foreach ($departments as $item){
            $data['departments'][] = $item->name;
            $data['approved'][] = $item->users->where('allowed', 1)->count();
            $data['unapproved'][] = $item->users->where('allowed', 0)->count();
            $data['total'][] = $item->users->count();
        }

        return view('admin.chart', compact('data'));
    }

    public function user_detail($id){
        $user = User::findOrFail($id);
        $kpis = KPI::all();
        return view('admin.user_detail', compact('user', 'kpis'));
    }


    public function change_detail(Request $request){
        $result = ['code' => 0, 'msg' => '', 'data' =>''];
        $user_id = $request->user_id;
        $code = $request->code;
        $set = $request->set;
        $type = $request->type;

        try {
            if ($set == 1){
                Detail::firstOrCreate(['user_id' => $user_id, 'department_code' => $code, 'type' => $type]);
                $result['code'] = 1;

            }else{
                Detail::where([['user_id', '=', $user_id ], ['department_code', '=', $code], ['type', '=', $type]])->delete();
                $result['code'] = 1;
            }
        }catch (\Exception $exception){
            $result['code'] = -1;
        }
        return response()->json($result, 200);
    }


    public function change_assign_kpi(Request $request){
        $result = ['code' => 0, 'msg' => '', 'data' =>''];
        $user_id = $request->user_id;
        $kpi_id = $request->kpi_id;
        $set = $request->set;

        try {
            if ($set == 1){
                AssignedKpi::firstOrCreate(['user_id' => $user_id, 'kpi_id' => $kpi_id]);
                $result['code'] = 1;

            }else{
                AssignedKpi::where([['user_id', '=', $user_id ], ['kpi_id', '=', $kpi_id]])->delete();
                $result['code'] = 1;
            }
        }catch (\Exception $exception){
            $result['code'] = -1;
            $result['msg'] = $exception->getMessage();
        }
        return response()->json($result, 200);
    }

}
