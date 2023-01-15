<?php

namespace App\Http\Controllers;

use App\Models\SubAttachment;
use App\Models\SubTask;
use App\Models\SubTaskAssignees;
use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use File;
class OtherSubDepartmentController extends Controller
{

    public function sub_detail(Request $request, $id){
        $task = SubTask::findOrFail($id);
        $members = $task->task->assignUsers;
        return view('other.sub_detail', compact('task', 'members'));
    }

    public function sub_create(Request $request){

        $task = Task::findOrFail($request->task_id);

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
        $leader_id = $task->leader_id; // leader is just boss in other department

        $sub_task = SubTask::create([
            'task_id' => $task->id,
            'leader_id' => $leader_id,
            'name' => $name,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'department_code' => $task->department_code,
            'status_change_date' => Carbon::now(),
        ]);

        foreach ($assignedTo as $user_id){
            SubTaskAssignees::create(['sub_task_id' => $sub_task->id, 'task_id' => $task->id, 'user_id' => $user_id]);
        }

        return redirect()->back()->with('success', 'Created task successfully');
    }

    public function sub_invite(Request $request){
        $task_id = $request->id;
        $assignedTo = $request->assignedTo;
        $sub_task = SubTask::findOrFail($task_id);
        if ($assignedTo){
            SubTaskAssignees::where('sub_task_id', $task_id)->delete();
            foreach ($assignedTo as $user_id){
                SubTaskAssignees::create(['sub_task_id' => $task_id, 'task_id' => $sub_task->task->id,'user_id' => $user_id]);
            }
        }
        return redirect()->back()->with('success', "Invited Successfully.");
    }


    public function sub_delete_member(Request $request){
        $member_id = $request->member_id;
        $task_id = $request->task_id;

        SubTaskAssignees::where('sub_task_id', $task_id)->where('user_id', $member_id)->delete();
        //start-delete tasks, subtasks whom this leader assigned to this big project created.
        //end-
        return redirect()->back()->with('success', 'Deleted successfully.');
    }


    public function sub_edit(Request $request){
        $id = $request->id;
        $description = $request->description;
        SubTask::where('id', $id)->update(['description' => $description]);
        return redirect()->back()->with('success', 'Edited successfully.');
    }


    public function sub_upload_file(Request $request){
        Validator::make($request->all(), [
            'files' => 'required',
//            'files.*' =>  'mimes:doc,pdf,docx,zip'
        ],  $messages = [
            'required' => 'The :attribute field is required.',
            'mimes' => "Invalid file type"
        ])->validate();

        $task_id = $request->id;

        if ($request->hasFile('files')){
            foreach ($request->file('files') as $file){
                $attach_origin_name = $file->getClientOriginalName();
                $ext = $file->getClientOriginalExtension();
                $file_name = str_replace(".".$ext, "", $attach_origin_name).time().".".$ext;
                $file_path = public_path('/attaches/');
                $file_size = $file->getSize() / 1024;
                //echo "filesize".$file_size; // getbyte
                $file->move($file_path, $file_name);

                SubAttachment::create([
                    'sub_id' => $task_id,
                    'path_name' => $file_name,
                    'real_name' => $attach_origin_name,
                    'file_size' => $file_size
                ]);
            }
        }
        return redirect()->back()->with('success', "Uploaded successfully.");
    }

    public function sub_delete_attachment(Request $request){
        $attachment_id = $request->attachment_id;
        $task_id = $request->task_id;
        $big_project = SubAttachment::find($attachment_id);
        if(File::exists(public_path('attaches/'.$big_project->path_name))){
            File::delete(public_path('attaches/'.$big_project->path_name));
        }
        SubAttachment::where('sub_id', $task_id)->where('id', $attachment_id)->delete();
        return redirect()->back()->with('success', 'Deleted successfully.');
    }

    public function sub_change_status(Request $request){
        SubTask::where('id', $request->id)->update(['status' => $request->status]);
        return redirect()->back()->with('success', 'Changed status successfully.');
    }
}
