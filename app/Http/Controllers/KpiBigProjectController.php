<?php

namespace App\Http\Controllers;

use App\Models\KpiBigAttachment;
use App\Models\KpiBigProject;
use App\Models\KpiBigProjectAssignee;
use App\Models\KpiProject;
use App\Models\KpiSubTask;
use App\Models\KpiTask;
use App\Models\Project;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use File;

class KpiBigProjectController extends Controller
{
    public function __construct()
    {
    }

    public function bigcreate($code)
    {
        $members = User::members($code);
        return view('kpibigproject.bigcreate', compact('members', 'code'));
    }

    public function create_big_project(Request $request)
    {
        Validator::make($request->all(), [
            'name' => 'required',
            //'description' => 'required',
            'start_date' => 'required|date',
            'end_date' => isset($request->end_date) ? 'date|after:start_date' : '',
            'assignedTo' => 'required',
            //'files' => 'required',
            //'files.*' =>  'mimes:doc,pdf,docx,zip'
        ],  $messages = [
            'required' => 'The :attribute field is required.',
            'after' => 'The :attribute has to be later regarding to start date'
        ])->validate();

        $name = $request->name;
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $assignedTo = $request->assignedTo;
        $department_code = $request->code;

        $big_project = KpiBigProject::create([
            'boss_id' => auth()->user()->getAuthIdentifier(),
            'name' => $name,
            'description' => '',
            'start_date' => $start_date,
            'end_date' => $end_date,
            'status_change_date' => Carbon::now(),
            'department_code' => $department_code
            //'status_change_date' => Carbon::now(),
        ]);


        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $attach_origin_name = $file->getClientOriginalName();
                $ext = $file->getClientOriginalExtension();
                $file_name = str_replace("." . $ext, "", $attach_origin_name) . uniqid() . "." . $ext;
                $file_path = public_path('/attaches/');
                $file_size = $file->getSize() / 1024;
                //echo "filesize".$file_size; // getbyte
                $file->move($file_path, $file_name);
                KpiBigAttachment::create([
                    'big_id' => $big_project->id,
                    'path_name' => $file_name,
                    'real_name' => $attach_origin_name,
                    'file_size' => $file_size
                ]);
            }
        }

        $big_project_id = $big_project->id;
        foreach ($assignedTo as $user_id) {
            KpiBigProjectAssignee::create(['big_project_id' => $big_project_id, 'leader_id' => $user_id]);
        }
        return redirect('kpibiglist/' . $department_code)->with('success', 'Created the big project successfully');
    }

    public function biglist(Request $request, $code)
    {
        $datefilter = $request->query("datefilter") ?? 'all';
        $filter = $request->query('filter');

        $select = KpiBigProject::select('*', DB::raw('DATEDIFF(end_date, start_date) as period'))
            ->where('department_code', $code);

        if (!empty($filter)) {
            if (!empty($datefilter)) {
                if ($datefilter === "all") {
                    $big_projects = $select
                        ->where('name', 'like', '%' . $filter . '%')
                        ->orderBy('id', 'desc')
                        ->paginate(config('constants.cnt_per_big_project_page'));
                } else if ($datefilter === "today") {
                    $date = Carbon::now()->subDays(0);
                    $big_projects = $select
                        ->whereDate('created_at', $date)
                        ->where('name', 'like', '%' . $filter . '%')
                        ->orderBy('id', 'desc')
                        ->paginate(config('constants.cnt_per_big_project_page'));
                } else if ($datefilter === 'yesterday') {
                    $date = Carbon::now()->subDays(1);
                    $big_projects = $select
                        ->whereDate('created_at', $date)
                        ->where('name', 'like', '%' . $filter . '%')
                        ->orderBy('id', 'desc')
                        ->paginate(config('constants.cnt_per_big_project_page'));
                } else if ($datefilter === 'last7days') {
                    $date = Carbon::now()->subDays(7);
                    $big_projects = $select
                        ->where('created_at', ">=", $date)
                        ->where('name', 'like', '%' . $filter . '%')
                        ->orderBy('id', 'desc')
                        ->paginate(config('constants.cnt_per_big_project_page'));
                } else if ($datefilter == 'last30days') {
                    $date = Carbon::now()->subDays(30);
                    $big_projects = $select
                        ->where('created_at', ">=", $date)
                        ->where('name', 'like', '%' . $filter . '%')
                        ->orderBy('id', 'desc')
                        ->paginate(config('constants.cnt_per_big_project_page'));
                } else if ($datefilter === 'lastyear') {
                    $date = Carbon::now()->subDays(364);
                    $big_projects = $select
                        ->where('created_at', ">=", $date)
                        ->where('name', 'like', '%' . $filter . '%')
                        ->orderBy('id', 'desc')
                        ->paginate(config('constants.cnt_per_big_project_page'));
                } else if ($datefilter === 'thismonth') {
                    $big_projects = $select
                        ->whereMonth('created_at', Carbon::now()->month)
                        ->where('name', 'like', '%' . $filter . '%')
                        ->orderBy('id', 'desc')
                        ->paginate(config('constants.cnt_per_big_project_page'));
                }
            } else {
                $big_projects = $select
                    ->where('name', 'like', '%' . $filter . '%')
                    ->orderBy('id', 'desc')
                    ->paginate(config('constants.cnt_per_big_project_page'));
            }
        } else {
            if (!empty($datefilter)) {
                if ($datefilter === "all") {
                    $big_projects = $select
                        ->orderBy('id', 'desc')
                        ->paginate(config('constants.cnt_per_big_project_page'));
                } else if ($datefilter === "today") {
                    $date = Carbon::now()->subDays(0);
                    $big_projects = $select
                        ->whereDate('created_at', $date)
                        ->orderBy('id', 'desc')
                        ->paginate(config('constants.cnt_per_big_project_page'));
                } else if ($datefilter === 'yesterday') {
                    $date = Carbon::now()->subDays(1);
                    $big_projects = $select
                        ->whereDate('created_at', $date)
                        ->orderBy('id', 'desc')
                        ->paginate(config('constants.cnt_per_big_project_page'));
                } else if ($datefilter === 'last7days') {
                    $date = Carbon::now()->subDays(7);
                    $big_projects = $select
                        ->where('created_at', ">=", $date)
                        ->orderBy('id', 'desc')
                        ->paginate(config('constants.cnt_per_big_project_page'));
                } else if ($datefilter == 'last30days') {
                    $date = Carbon::now()->subDays(30);
                    $big_projects = $select
                        ->where('created_at', ">=", $date)
                        ->orderBy('id', 'desc')
                        ->paginate(config('constants.cnt_per_big_project_page'));
                } else if ($datefilter === 'lastyear') {
                    $date = Carbon::now()->subDays(364);
                    $big_projects = $select
                        ->where('created_at', ">=", $date)
                        ->orderBy('id', 'desc')
                        ->paginate(config('constants.cnt_per_big_project_page'));
                } else if ($datefilter === 'thismonth') {
                    $big_projects = $select
                        ->whereMonth('created_at', Carbon::now()->month)
                        ->orderBy('id', 'desc')
                        ->paginate(config('constants.cnt_per_big_project_page'));
                }
            } else {
                $big_projects = $select
                    ->orderBy('id', 'desc')
                    ->paginate(config('constants.cnt_per_big_project_page'));
            }
        }
        return view('kpibigproject.biglist', compact('big_projects', 'filter', 'datefilter', 'code'));
    }


    public function detail(Request $request, $big_project_id)
    {
        $big_project = KpiBigProject::findOrFail($big_project_id);
        $members = User::members($big_project->department_code);
        // return $members;
        return view('kpibigproject.detail', compact('big_project', 'members'));
    }

    public function edit($big_project_id)
    {
        $big_project = KpiBigProject::findOrFail($big_project_id);
        return view('kpibigproject.edit', compact('big_project'));
    }

    public function p_edit(Request $request)
    {
        $id = $request->id;
        $data = $request->except('id', '_token');

        $data['status_change_date'] = Carbon::now();
        KpiBigProject::where('id', $id)->update($data);
        return redirect("kpibigproject/detail/" . $id)->with('success', 'Updated successfully.');
    }

    public function delete_leader(Request $request)
    {
        $leader_id = $request->leader_id;
        $big_project_id = $request->big_project_id;
        KpiBigProjectAssignee::where('big_project_id', $big_project_id)->where('leader_id', $leader_id)->delete();
        //start-delete projects, tasks, subtasks whom this leader assigned to this big project created.

        //end-
        return redirect()->back()->with('success', 'Deleted successfully.');
    }


    public function invite(Request $request)
    {
        $assignedTo = $request->assignedTo;
        $big_project_id = $request->id;
        if ($assignedTo) {
            KpiBigProjectAssignee::where('big_project_id', $big_project_id)->delete();
            foreach ($assignedTo as $user_id) {
                KpiBigProjectAssignee::create(['big_project_id' => $big_project_id, 'leader_id' => $user_id]);
            }
        }
        return redirect()->back()->with('success', "Invited Successfully.");
    }

    public function delete_attachment(Request $request)
    {
        $attachment_id = $request->attachment_id;
        $big_project_id = $request->big_project_id;

        $big_project = KpiBigAttachment::findOrFail($attachment_id);
        if (File::exists(public_path('attaches/' . $big_project->path_name))) {
            File::delete(public_path('attaches/' . $big_project->path_name));
        }

        KpiBigAttachment::where('big_id', $big_project_id)->where('id', $attachment_id)->delete();
        return redirect()->back()->with('success', 'Deleted successfully.');
    }

    public function upload_file(Request $request)
    {
        Validator::make($request->all(), [
            'files' => 'required',
            //            'files.*' =>  'mimes:doc,pdf,docx,zip'
        ],  $messages = [
            'required' => 'The :attribute field is required.',
            'mimes' => "Invalid file type"
        ])->validate();

        $big_project_id = $request->id;

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $attach_origin_name = $file->getClientOriginalName();
                $ext = $file->getClientOriginalExtension();
                $file_name = str_replace("." . $ext, "", $attach_origin_name) . time() . "." . $ext;
                $file_path = public_path('/attaches/');
                $file_size = $file->getSize() / 1024;
                //echo "filesize".$file_size; // getbyte
                $file->move($file_path, $file_name);

                KpiBigAttachment::create([
                    'big_id' => $big_project_id,
                    'path_name' => $file_name,
                    'real_name' => $attach_origin_name,
                    'file_size' => $file_size
                ]);
            }
        }
        return redirect()->back()->with('success', "Uploaded successfully.");
    }

    public function delete_bigproject(Request $request)
    {
        $id = $request->big_project_id;

        $attaches = KpiBigAttachment::where('big_id', $id)->get();
        foreach ($attaches as $item) {
            if (File::exists(public_path('attaches/' . $item->path_name))) {
                File::delete(public_path('attaches/' . $item->path_name));
            }
        }
        KpiBigProject::where('id', $id)->delete();
        return redirect()->back()->with('success', "Deleted successfully.");
    }


    public function bigproject_chart(Request $request)
    {
        if ($request->year) {
            $year = $request->year;
        } else {
            $year = Carbon::now()->year;
        }

        $id = $request->id;
        $big_project = KpiBigProject::find($id); { // bar chart
            $total = array();
            $pending = array();
            $inprogress = array();
            $completed = array();
            $notyetstarted = array();
            $overdue = array();
            $cancelled = array();
            for ($i = 1; $i <= 12; $i++) {
                array_push($pending, KpiProject::where('big_project_id', $id)->whereYear('status_change_date', $year)->where('status', 'pending')->whereMonth('status_change_date', $i)->count());
                array_push($inprogress, KpiProject::where('big_project_id', $id)->whereYear('status_change_date', $year)->where('status', 'inprogress')->whereMonth('status_change_date', $i)->count());
                array_push($completed, KpiProject::where('big_project_id', $id)->whereYear('status_change_date', $year)->where('status', 'completed')->whereMonth('status_change_date', $i)->count());
                array_push($notyetstarted, KpiProject::where('big_project_id', $id)->whereYear('status_change_date', $year)->where('status', 'notyetstarted')->whereMonth('status_change_date', $i)->count());
                array_push($cancelled, KpiProject::where('big_project_id', $id)->whereYear('status_change_date', $year)->where('status', 'cancelled')->whereMonth('status_change_date', $i)->count());
                array_push($overdue, KpiProject::where('big_project_id', $id)->whereYear('status_change_date', $year)->where('status', 'overdue')->whereMonth('status_change_date', $i)->count());
                array_push($total, KpiProject::where('big_project_id', $id)->whereYear('status_change_date', $year)->whereMonth('status_change_date', $i)->count());
            }

            $bar_chart = array(
                'pending' => $pending,
                'inprogress' => $inprogress,
                'completed' => $completed,
                'notyetstarted' => $notyetstarted,
                'overdue' => $overdue,
                'cancelled' => $cancelled,
                'total' => $total
            );
        }
        $view = View('kpibigproject.item', compact('big_project', 'bar_chart', 'year'))->render();
        return $view;
    }


    public function m_edit(Request $request)
    { 
        $id = $request->id;
        $data = $request->except('id', '_token');
        $data['status_change_date'] = Carbon::now();
        KpiBigProject::where('id', $id)->update($data);
        return redirect("kpibigproject/detail/" . $id)->with('success', 'Updated successfully.');
    }


    public function change_status(Request $request)
    {
        $type = $request->type;
        $id = $request->id;
        $status = $request->status;
        if ($type == 0) { // big project
            $model = KpiBigProject::findOrFail($id);
        } else if ($type == 1) { // project
            $model = KpiProject::findOrFail($id);
        } else if ($type == 2) { // task
            $model = KpiTask::findOrFail($id);
        } else
            $model = KpiSubTask::findOrFail($id);

        $model->status = $status;
        $model->save();

        return redirect()->back()->with('success', 'Changed Successfully');
    }
}
