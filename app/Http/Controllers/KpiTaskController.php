<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\KpiProject;
use App\Models\KpiTask;
use App\Models\KpiTaskAssignee;
use App\Models\KpiTaskAttachment;
use App\Models\KpiTaskLeader;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use File;
use Carbon\Carbon;

class KpiTaskController extends Controller
{
    public function task($task_id)
    {
        echo $task_id;
    }

    public function mytask(Request $request)
    {
        $user = auth()->user();
        $tasks = $user->kpi_tasks()->paginate(10);
        return view('kpitask.mytasks', compact('tasks'));
    }

    public function tasklist()
    {
        return view('kpitask.tasklist');
    }

    public function taskcreate()
    {
        return view('kpitask.taskcreate');
    }

    public function task_create($project_id)
    {

        $members = KpiProject::find($project_id)->assignUsers;
        return view('kpitask.create', compact('project_id', 'members'));
    }

    public function p_task_create(Request $request, $project_id)
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

        $project = KpiProject::findOrFail($project_id);
        $name = $request->name;
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $assignedTo = $request->assignedTo;
        $department_code = $project->department_code;
        $user = auth()->user();
        $leader_id = $user->id;

        $task = KpiTask::create([
            'project_id' => $project_id,
            'leader_id' => $leader_id,
            'name' => $name,
            'description' => "",
            'start_date' => $start_date,
            'end_date' => $end_date,
            'department_code' => $department_code,
            'status_change_date' => Carbon::now(),
        ]);

        KpiTaskLeader::create([
            'task_id' => $task->id,
            'project_id' => $project_id,
            'leader_id' => $leader_id
        ]);

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $attach_origin_name = $file->getClientOriginalName();
                $ext = $file->getClientOriginalExtension();
                $file_name = str_replace("." . $ext, "", $attach_origin_name) . time() . "." . $ext;
                $file_path = public_path('/attaches/');
                $file_size = $file->getSize() / 1024;
                //echo "filesize".$file_size; // getbyte
                $file->move($file_path, $file_name);

                KpiTaskAttachment::create([
                    'task_id' => $task->id,
                    'path_name' => $file_name,
                    'real_name' => $attach_origin_name,
                    'file_size' => $file_size
                ]);
            }
        }

        foreach ($assignedTo as $user_id) {
            KpiTaskAssignee::create(['task_id' => $task->id, 'project_id' => $project_id, 'user_id' => $user_id]);
        }
        return redirect('/kpiproject/detail/' . $project_id)->with('success', 'Created task successfully');
    }



    public function task_detail($task_id)
    {
        $task = KpiTask::findOrFail($task_id);
        $comments = $task->comments;
        $members = $task->project->assignUsers;
        $leaders = User::members(auth()->user()->department_code);
        return view('kpitask.detail', compact('task', 'members', 'leaders', 'comments'));
    }

    public function add_comment(Request $request, $id)
    {
        $task = KpiTask::find($id);

        $comment = new Comment();
        $comment->body = $request->comment;
        $comment->user_id = auth()->user()->id;

        $task->comments()->save($comment);
        $comments = $task->comments;

        return view('comments.comment', compact('comments'))->render();
    }



    public function task_edit($task_id)
    {
        $task = KpiTask::findOrFail($task_id);
        return view('kpitask.edit', compact('task'));
    }


    public function p_task_edit(Request $request)
    {
        $id = $request->id;
        $data = $request->except('id', '_token');
        $data['status_change_date'] = Carbon::now();
        KpiTask::where('id', $id)->update($data);
        return redirect("kpitask/detail/" . $id)->with('success', 'Updated successfully.');
    }

    public function task_delete_member(Request $request)
    {
        $member_id = $request->member_id;
        $task_id = $request->task_id;

        KpiTaskAssignee::where('task_id', $task_id)->where('user_id', $member_id)->delete();
        //start-delete tasks, subtasks whom this leader assigned to this big project created.
        //end-
        return redirect()->back()->with('success', 'Deleted successfully.');
    }
    public function task_delete_leader(Request $request)
    {
        $leader_id = $request->leader_id;
        $task_id = $request->task_id;
        $taskLeaderObj = KpiTaskLeader::where('task_id', $task_id);
        $manager_count = $taskLeaderObj->count();
        if ($manager_count > 1) {
            $taskLeaderObj->where('leader_id', $leader_id)->delete();
            return redirect()->back()->with('success', 'Deleted successfully.');
        }
        return redirect()->back()->with('warning', 'Please assign another leader first.');
    }

    public function task_member_invite(Request $request)
    {
        $task_id = $request->id;
        $assignedTo = $request->assignedTo;
        $task = KpiTask::findOrFail($task_id);
        if ($assignedTo) {
            KpiTaskAssignee::where('task_id', $task_id)->delete();
            foreach ($assignedTo as $user_id) {
                KpiTaskAssignee::create(['task_id' => $task_id, 'project_id' => $task->project->id, 'user_id' => $user_id]);
            }
        }
        return redirect()->back()->with('success', "Invited Successfully.");
    }
    public function task_leader_invite(Request $request)
    {
        $task_id = $request->id;
        $assignedTo = $request->assignedTo;
        $task = KpiTask::findOrFail($task_id);
        if ($assignedTo) {
            KpiTaskLeader::where('task_id', $task_id)->delete();
            foreach ($assignedTo as $user_id) {
                KpiTaskLeader::create(['task_id' => $task_id, 'project_id' => $task->project->id, 'leader_id' => $user_id]);
            }
        }
        return redirect()->back()->with('success', "Invited Successfully.");
    }

    public function task_delete_project(Request $request)
    {
        $task_id = $request->task_id;
        $attaches = KpiTaskAttachment::where('task_id', $task_id)->get();
        foreach ($attaches as $item) {
            if (File::exists(public_path('attaches/' . $item->path_name))) {
                File::delete(public_path('attaches/' . $item->path_name));
            }
        }
        KpiTask::findOrFail($task_id)->delete();
        return redirect()->back()->with('success', "Deleted successfully.");
    }

    public function task_upload_file(Request $request)
    {
        Validator::make($request->all(), [
            'files' => 'required',
            //'files.*' =>  'mimes:doc,pdf,docx,zip'
        ],  $messages = [
            'required' => 'The :attribute field is required.',
            'mimes' => "Invalid file type"
        ])->validate();

        $task_id = $request->id;

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $attach_origin_name = $file->getClientOriginalName();
                $ext = $file->getClientOriginalExtension();
                $file_name = str_replace("." . $ext, "", $attach_origin_name) . uniqid() . "." . $ext;
                $file_path = public_path('/attaches/');
                $file_size = $file->getSize() / 1024;
                //echo "filesize".$file_size; // getbyte
                $file->move($file_path, $file_name);

                KpiTaskAttachment::create([
                    'task_id' => $task_id,
                    'path_name' => $file_name,
                    'real_name' => $attach_origin_name,
                    'file_size' => $file_size
                ]);
            }
        }
        return redirect()->back()->with('success', "Uploaded successfully.");
    }


    public function task_delete_attachment(Request $request)
    {
        $attachment_id = $request->attachment_id;
        $task_id = $request->task_id;

        $big_project = KpiTaskAttachment::find($attachment_id);
        if (File::exists(public_path('attaches/' . $big_project->path_name))) {
            File::delete(public_path('attaches/' . $big_project->path_name));
        }
        KpiTaskAttachment::where('task_id', $task_id)->where('id', $attachment_id)->delete();
        return redirect()->back()->with('success', 'Deleted successfully.');
    }
}
