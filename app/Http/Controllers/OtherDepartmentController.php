<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Project;
use App\Models\Task;
use App\Models\TaskAssignee;
use App\Models\TaskAttachment;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use File;

class OtherDepartmentController extends Controller
{
    public function __construct()
    {
        $this->count_per_page = 5;
    }

    public function tasks(Request $request,  $code)
    {
        $department_code = $code;
        $department = Department::where('code', $code)->first();
        if ($code == 1)
            return redirect('biglist/' . $code);
        if ($code == 6)
            return redirect('kpibiglist/' . $code);

        $current_user = auth()->user();

        $users = User::members($department_code);

        $filter = $request->query('filter');
        $sort = $request->sort;
        $direction = $request->direction;

        if (!empty($filter)) {
            $projects = Task::sortable()
                ->select(['tasks.*', 'users.name as username'])
                ->leftJoin('task_assignees', function ($join) {
                    $join->on('tasks.id', '=', 'task_assignees.task_id');
                })
                ->leftJoin('users', function ($join) {
                    $join->on('task_assignees.user_id', '=', 'users.id');
                })
                ->where('users.name', 'like', '%' . $filter . '%')
                ->where('tasks.department_code', $department_code)
                ->groupBy('tasks.id')
                ->orderBy('tasks.id', 'desc')
                ->paginate($this->count_per_page);
        } else {
            $projects = Task::sortable()
                ->where('department_code', $department_code)
                ->orderBy('id', 'desc')
                ->paginate($this->count_per_page);
        }

        return view('other.tasks', [
            'users' => $users,
            'projects' => $projects, 'filter' => $filter, 'sort' => $sort, 'direction' => $direction, 'code' => $code,
            'current_user' => $current_user, 'department' => $department
        ]);
    }

    public function detail($id)
    {
        $task = Task::findOrFail($id);
        $members = User::members($task->department_code);
        return view('other.detail', compact('task', 'members'));
    }

    public function create(Request $request)
    {
        Validator::make($request->all(), [
            'name' => 'required',
            'start_date' => 'required|date',
            'end_date' => isset($request->end_date) ? 'date|after:start_date' : '',
            'assignedTo' => 'required',
        ],  $messages = [
            'required' => 'The :attribute field is required.',
            'after' => 'The :attribute has to be later regarding to start date'
        ])->validate();


        $name = $request->name;
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $assignedTo = $request->assignedTo;
        $department_code = $request->department_code;
        $user = auth()->user();
        $leader_id = $user->id; // leader is just boss in other department

        $task = Task::create([
            'leader_id' => $leader_id,
            'name' => $name,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'department_code' => $department_code,
            'status_change_date' => Carbon::now(),
        ]);

        foreach ($assignedTo as $user_id) {
            TaskAssignee::create(['task_id' => $task->id, 'user_id' => $user_id]);
        }
        return redirect()->back()->with('success', 'Created task successfully');
    }

    public function invite(Request $request)
    {
        $task_id = $request->id;
        $assignedTo = $request->assignedTo;
        $task = Task::findOrFail($task_id);
        if ($assignedTo) {
            TaskAssignee::where('task_id', $task_id)->delete();
            foreach ($assignedTo as $user_id) {
                TaskAssignee::create(['task_id' => $task_id, 'user_id' => $user_id]);
            }
        }
        return redirect()->back()->with('success', "Invited Successfully.");
    }


    public function delete_member(Request $request)
    {
        $member_id = $request->member_id;
        $task_id = $request->task_id;

        TaskAssignee::where('task_id', $task_id)->where('user_id', $member_id)->delete();
        //start-delete tasks, subtasks whom this leader assigned to this big project created.
        //end-
        return redirect()->back()->with('success', 'Deleted successfully.');
    }


    public function edit(Request $request)
    {
        $id = $request->id;
        $description = $request->description;
        Task::where('id', $id)->update(['description' => $description]);
        return redirect()->back()->with('success', 'Edited successfully.');
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

        $task_id = $request->id;

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
                    'task_id' => $task_id,
                    'path_name' => $file_name,
                    'real_name' => $attach_origin_name,
                    'file_size' => $file_size
                ]);
            }
        }
        return redirect()->back()->with('success', "Uploaded successfully.");
    }

    public function delete_attachment(Request $request)
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

    public function change_status(Request $request)
    {
        Task::where('id', $request->id)->update(['status' => $request->status]);
        return redirect()->back()->with('success', 'Changed status successfully.');
    }
}
