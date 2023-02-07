<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use App\Models\TaskAssignee;
use App\Models\TaskAttachment;
use App\Models\TaskLeader;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use File;

class TaskController extends Controller
{
    public function task($task_id)
    {
        echo $task_id;
    }

    public function mytask(Request $request)
    {
        $user = auth()->user();
        $tasks = $user->tasks()->paginate(10);
        return view('task.mytasks', compact('tasks'));
    }

    public function tasklist()
    {
        return view('task.tasklist');
    }

    public function taskcreate()
    {
        return view('task.taskcreate');
    }

    public function task_create($project_id)
    {

        $members = Project::find($project_id)->assignUsers;
        return view('task.create', compact('project_id', 'members'));
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

        $project = Project::findOrFail($project_id);
        $name = $request->name;
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $assignedTo = $request->assignedTo;
        $department_code = $project->department_code;
        $user = auth()->user();
        $leader_id = $user->id;

        $task = Task::create([
            'project_id' => $project_id,
            'leader_id' => $leader_id,
            'name' => $name,
            'description' => "",
            'start_date' => $start_date,
            'end_date' => $end_date,
            'department_code' => $department_code,
            'status_change_date' => Carbon::now(),
        ]);

        TaskLeader::create([
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

                TaskAttachment::create([
                    'task_id' => $task->id,
                    'path_name' => $file_name,
                    'real_name' => $attach_origin_name,
                    'file_size' => $file_size
                ]);
            }
        }

        foreach ($assignedTo as $user_id) {
            TaskAssignee::create(['task_id' => $task->id, 'project_id' => $project_id, 'user_id' => $user_id]);
        }
        return redirect('/project/detail/' . $project_id)->with('success', 'Created task successfully');
    }



    public function task_detail($task_id)
    {
        $task = Task::findOrFail($task_id);
        $members = $task->project->assignUsers;
        $leaders = User::members(auth()->user()->department_code);
        return view('task.detail', compact('task', 'members', 'leaders'));
    }



    public function task_edit($task_id)
    {
        $task = Task::findOrFail($task_id);
        return view('task.edit', compact('task'));
    }


    public function p_task_edit(Request $request)
    {
        $id = $request->id;
        $data = $request->except('id', '_token');
        $data['status_change_date'] = Carbon::now();
        Task::where('id', $id)->update($data);
        return redirect("task/detail/" . $id)->with('success', 'Updated successfully.');
    }

    public function task_delete_member(Request $request)
    {
        $member_id = $request->member_id;
        $task_id = $request->task_id;

        TaskAssignee::where('task_id', $task_id)->where('user_id', $member_id)->delete();
        //start-delete tasks, subtasks whom this leader assigned to this big project created.
        //end-
        return redirect()->back()->with('success', 'Deleted successfully.');
    }

    public function task_delete_leader(Request $request)
    {
        $leader_id = $request->leader_id;
        $task_id = $request->task_id;
        $taskLeaderObj = TaskLeader::where('task_id', $task_id);
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
        $task = Task::findOrFail($task_id);
        if ($assignedTo) {
            TaskAssignee::where('task_id', $task_id)->delete();
            foreach ($assignedTo as $user_id) {
                TaskAssignee::create(['task_id' => $task_id, 'project_id' => $task->project->id, 'user_id' => $user_id]);
            }
        }
        return redirect()->back()->with('success', "Invited Successfully.");
    }

    public function task_invite_leader(Request $request)
    {
        $task_id = $request->id;
        $assignedTo = $request->assignedTo;
        $task = Task::findOrFail($task_id);
        if ($assignedTo) {
            TaskLeader::where('task_id', $task_id)->delete();
            foreach ($assignedTo as $user_id) {
                TaskLeader::create(['task_id' => $task_id, 'project_id' => $task->project->id, 'leader_id' => $user_id]);
            }
        }
        return redirect()->back()->with('success', "Invited Successfully.");
    }

    public function task_delete_project(Request $request)
    {
        $task_id = $request->task_id;
        $attaches = TaskAttachment::where('task_id', $task_id)->get();
        foreach ($attaches as $item) {
            if (File::exists(public_path('attaches/' . $item->path_name))) {
                File::delete(public_path('attaches/' . $item->path_name));
            }
        }
        Task::findOrFail($task_id)->delete();
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

                TaskAttachment::create([
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

        $big_project = TaskAttachment::find($attachment_id);
        if (File::exists(public_path('attaches/' . $big_project->path_name))) {
            File::delete(public_path('attaches/' . $big_project->path_name));
        }
        TaskAttachment::where('task_id', $task_id)->where('id', $attachment_id)->delete();
        return redirect()->back()->with('success', 'Deleted successfully.');
    }
}
