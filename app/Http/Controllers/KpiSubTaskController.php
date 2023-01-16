<?php

namespace App\Http\Controllers;

use App\Models\KpiSubTask;
use App\Models\KpiSubTaskAssignees;
use App\Models\KpiSubTaskAttachment;
use App\Models\KpiTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use File;
use Carbon\Carbon;

class KpiSubTaskController extends Controller
{
    public function sublist()
    {
        return view('kpisubtask.sublist');
    }

    public function subcreate()
    {
        return view('kpisubtask.subcreate');
    }

    public function sub_task_create($task_id)
    {
        $members = KpiTask::find($task_id)->assignUsers;
        return view('kpisubtask.create', compact('task_id', 'members'));
    }

    public function p_sub_task_create(Request $request, $task_id)
    {
        Validator::make($request->all(), [
            'name' => 'required',
            'start_date' => 'required|date',
            'end_date' => isset($request->end_date) ? 'date|after:start_date' : '',
            'assignedTo' => 'required',
            //'files' => 'required',
            //'files.*' =>  'mimes:doc,pdf,docx,zip'
        ],  $messages = [
            'required' => 'The :attribute field is required.',
            'after' => 'The :attribute has to be later regarding to start date'
        ])->validate();

        $task = KpiTask::findOrFail($task_id);
        $name = $request->name;
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $assignedTo = $request->assignedTo;
        $department_code = $task->department_code;
        $user = auth()->user();
        $leader_id = $user->id;

        $sub_task = KpiSubTask::create([
            'task_id' => $task_id,
            'leader_id' => $leader_id,
            'name' => $name,
            'description' => "",
            'start_date' => $start_date,
            'end_date' => $end_date,
            'department_code' => $department_code,
            'status_change_date' => Carbon::now(),
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

                KpiSubTaskAttachment::create([
                    'sub_id' => $sub_task->id,
                    'path_name' => $file_name,
                    'real_name' => $attach_origin_name,
                    'file_size' => $file_size
                ]);
            }
        }

        foreach ($assignedTo as $user_id) {
            KpiSubTaskAssignees::create(['sub_task_id' => $sub_task->id, 'task_id' => $task_id, 'user_id' => $user_id]);
        }
        return redirect('/kpitask/detail/' . $task_id)->with('success', 'Created project successfully');
    }

    public function sub_task_detail($sub_task_id)
    {
        $sub_task = KpiSubTask::findOrFail($sub_task_id);
        $members = $sub_task->task->assignUsers;
        return view('kpisubtask.detail', compact('sub_task', 'members'));
    }


    public function sub_task_edit($sub_task_id)
    {
        $sub_task = KpiSubTask::findOrFail($sub_task_id);
        return view('kpisubtask.edit', compact('sub_task'));
    }
    public function p_sub_task_edit(Request $request)
    {
        $id = $request->id;
        $data = $request->except('id', '_token');
        $data['status_change_date'] = Carbon::now();
        KpiSubTask::where('id', $id)->update($data);
        return redirect("kpisubtask/detail/" . $id)->with('success', 'Updated successfully.');
    }

    public function sub_task_delete_member(Request $request)
    {
        $member_id = $request->member_id;
        $sub_task_id = $request->sub_task_id;

        KpiSubTaskAssignees::where('sub_task_id', $sub_task_id)->where('user_id', $member_id)->delete();
        //start-delete tasks, subtasks whom this leader assigned to this big project created.
        //end-
        return redirect()->back()->with('success', 'Deleted successfully.');
    }

    public function sub_task_member_invite(Request $request)
    {
        $sub_task_id = $request->id;
        $assignedTo = $request->assignedTo;
        $sub_task = KpiSubTask::findOrFail($sub_task_id);
        if ($assignedTo) {
            KpiSubTaskAssignees::where('sub_task_id', $sub_task_id)->delete();
            foreach ($assignedTo as $user_id) {
                KpiSubTaskAssignees::create(['sub_task_id' => $sub_task_id, 'task_id' => $sub_task->task->id, 'user_id' => $user_id]);
            }
        }
        return redirect()->back()->with('success', "Invited Successfully.");
    }


    public function sub_task_delete_project(Request $request)
    {
        $sub_task_id = $request->sub_task_id;
        $attaches = KpiSubTaskAttachment::where('sub_id', $sub_task_id)->get();
        foreach ($attaches as $item) {
            if (File::exists(public_path('attaches/' . $item->path_name))) {
                File::delete(public_path('attaches/' . $item->path_name));
            }
        }
        KpiSubTask::findOrFail($sub_task_id)->delete();
        return redirect()->back()->with('success', "Deleted successfully.");
    }

    public function sub_task_upload_file(Request $request)
    {
        Validator::make($request->all(), [
            'files' => 'required',
            //            'files.*' =>  'mimes:doc,pdf,docx,zip'
        ],  $messages = [
            'required' => 'The :attribute field is required.',
            'mimes' => "Invalid file type"
        ])->validate();

        $sub_task_id = $request->id;

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $attach_origin_name = $file->getClientOriginalName();
                $ext = $file->getClientOriginalExtension();
                $file_name = str_replace("." . $ext, "", $attach_origin_name) . time() . "." . $ext;
                $file_path = public_path('/attaches/');
                $file_size = $file->getSize() / 1024;
                //echo "filesize".$file_size; // getbyte
                $file->move($file_path, $file_name);

                KpiSubTaskAttachment::create([
                    'sub_id' => $sub_task_id,
                    'path_name' => $file_name,
                    'real_name' => $attach_origin_name,
                    'file_size' => $file_size
                ]);
            }
        }
        return redirect()->back()->with('success', "Uploaded successfully.");
    }
    public function sub_task_delete_attachment(Request $request)
    {
        $attachment_id = $request->attachment_id;
        $sub_task_id = $request->sub_task_id;

        $big_project = KpiSubTaskAttachment::find($attachment_id);
        if (File::exists(public_path('attaches/' . $big_project->path_name))) {
            File::delete(public_path('attaches/' . $big_project->path_name));
        }
        KpiSubTaskAttachment::where('sub_id', $sub_task_id)->where('id', $attachment_id)->delete();
        return redirect()->back()->with('success', 'Deleted successfully.');
    }
}
