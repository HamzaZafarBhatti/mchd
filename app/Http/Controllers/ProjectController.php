<?php

namespace App\Http\Controllers;

use App\Helper\Helper;
use App\Models\BigProject;
use App\Models\ProAttachment;
use App\Models\Project;
use App\Models\ProjectAssignee;
use App\Models\ProjectLeader;
use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use File;

class ProjectController extends Controller
{


    /**
     * ProjectController constructor.
     */
    public function __construct()
    {
        $this->count_per_page = 5;
    }


    public function project_create($big_project_id){
        $big_project = BigProject::findOrFail($big_project_id);
        $members = User::members($big_project->department_code);
        return view('project.create', compact('members', 'big_project_id'));
    }


    public function post_project(Request $request){
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


        $big_project_id = $request->big_project_id;
        $big_project = BigProject::findOrFail($big_project_id);
        $name = $request->name;
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $assignedTo = $request->assignedTo;
        $department_code = $big_project->department_code;
        $user = auth()->user();
        $leader_id = $user->id;

        $project = Project::create([
            'big_project_id' => $big_project_id,
            'leader_id' => $leader_id,
            'name' => $name,
            'description' => "",
            'start_date' => $start_date,
            'end_date' => $end_date,
            'department_code' => $department_code,
            'status_change_date' => Carbon::now(),
        ]);

        ProjectLeader::create([
            'project_id' => $project->id,
            'leader_id' => $leader_id,
        ]);

        if ($request->hasFile('files')){
            foreach ($request->file('files') as $file){
                $attach_origin_name = $file->getClientOriginalName();
                $ext = $file->getClientOriginalExtension();
                $file_name = str_replace(".".$ext, "", $attach_origin_name).time().".".$ext;
                $file_path = public_path('/attaches/');
                $file_size = $file->getSize() / 1024;
                //echo "filesize".$file_size; // getbyte
                $file->move($file_path, $file_name);

                ProAttachment::create([
                    'pro_id' => $project->id,
                    'path_name' => $file_name,
                    'real_name' => $attach_origin_name,
                    'file_size' => $file_size
                ]);
            }
        }

        $project_id = $project->id;
        foreach ($assignedTo as $user_id){
            ProjectAssignee::create(['project_id' => $project_id, 'user_id' => $user_id]);
        }
        return redirect('/bigproject/detail/'.$big_project_id)->with('success', 'Created project successfully');
    }

    public function project_detail($big_project_id){
        $project = Project::findOrFail($big_project_id);
        $members = User::members(auth()->user()->department_code);
        return view('project.detail', compact('project', 'members'));
    }

    public function project_edit($project_id){
        $project = Project::findOrFail($project_id);
        return view('project.edit', compact('project'));
    }

    public function p_project_edit(Request $request){
        $id = $request->id;
        $data = $request->except('id', '_token');
        $data['status_change_date'] = Carbon::now();
        Project::where('id', $id)->update($data);
        return redirect("project/detail/".$id)->with('success', 'Updated successfully.');
    }

    public function delete_member(Request $request){
        $member_id = $request->member_id;
        $project_id = $request->project_id;

        ProjectAssignee::where('project_id', $project_id)->where('user_id', $member_id)->delete();
        //start-delete tasks, subtasks whom this leader assigned to this big project created.
        //end-
        return redirect()->back()->with('success', 'Deleted successfully.');
    }
    public function delete_leader(Request $request){
        $leader_id = $request->leader_id;
        $project_id = $request->project_id;
        $projectLeaderObj = ProjectLeader::where('project_id', $project_id);
        $manager_count = $projectLeaderObj->count();
        if($manager_count > 1) {
            $projectLeaderObj->where('leader_id', $leader_id)->delete();
            return redirect()->back()->with('success', 'Deleted successfully.');
        }
        return redirect()->back()->with('warning', 'Please assign another leader first.');
    }


    public function project_member_invite(Request $request){
        $project_id = $request->id;
        $assignedTo = $request->assignedTo;
        if ($assignedTo){
            ProjectAssignee::where('project_id', $project_id)->delete();
            foreach ($assignedTo as $user_id){
                ProjectAssignee::create(['project_id' => $project_id, 'user_id' => $user_id]);
            }
        }
        return redirect()->back()->with('success', "Invited Successfully.");
    }
    public function project_leader_invite(Request $request){
        $project_id = $request->id;
        $assignedTo = $request->assignedTo;
        if ($assignedTo){
            ProjectLeader::where('project_id', $project_id)->delete();
            foreach ($assignedTo as $user_id){
                ProjectLeader::create(['project_id' => $project_id, 'leader_id' => $user_id]);
            }
        }
        return redirect()->back()->with('success', "Invited Successfully.");
    }

    public function delete_project_v2(Request $request){

        $project_id = $request->project_id;
        $attaches = ProAttachment::where('pro_id', $project_id)->get();
        foreach ($attaches as $item){
            if(File::exists(public_path('attaches/'.$item->path_name))){
                File::delete(public_path('attaches/'.$item->path_name));
            }
        }
        Project::findOrFail($project_id)->delete();
        return redirect()->back()->with('success', "Deleted successfully.");
    }


    public function project_upload_file(Request $request){
        Validator::make($request->all(), [
            'files' => 'required',
            //'files.*' =>  'mimes:doc,pdf,docx,zip'
        ],  $messages = [
            'required' => 'The :attribute field is required.',
            'mimes' => "Invalid file type"
        ])->validate();

        $project_id = $request->id;

        if ($request->hasFile('files')){
            foreach ($request->file('files') as $file){
                $attach_origin_name = $file->getClientOriginalName();
                $ext = $file->getClientOriginalExtension();
                $file_name = str_replace(".".$ext, "", $attach_origin_name).uniqid().".".$ext;
                $file_path = public_path('/attaches/');
                $file_size = $file->getSize() / 1024;
                //echo "filesize".$file_size; // getbyte
                $file->move($file_path, $file_name);

                ProAttachment::create([
                    'pro_id' => $project_id,
                    'path_name' => $file_name,
                    'real_name' => $attach_origin_name,
                    'file_size' => $file_size
                ]);
            }
        }
        return redirect()->back()->with('success', "Uploaded successfully.");
    }

    public function project_delete_attachment(Request $request){
        $attachment_id = $request->attachment_id;
        $project_id = $request->project_id;

        $big_project = ProAttachment::find($attachment_id);
        if(File::exists(public_path('attaches/'.$big_project->path_name))){
            File::delete(public_path('attaches/'.$big_project->path_name));
        }
        ProAttachment::where('pro_id', $project_id)->where('id', $attachment_id)->delete();
        return redirect()->back()->with('success', 'Deleted successfully.');
    }




}
