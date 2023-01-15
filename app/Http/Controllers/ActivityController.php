<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\UserActivity;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function index(Project $project)
    {
        $activityQuery = UserActivity::query();

        $activityQuery->where(function ($query) use ($project) {
            $query->where('object_id', $project->id);
            $query->where('object_type', 'project');
        });

        $activityQuery->orWhere(function ($query) use ($project) {
            $query->whereIn('object_id', $project->tasks->pluck('id'));
            $query->where('object_type', 'task');
        });

//        $activityQuery->orWhere(function ($query) use ($project) {
//            $query->whereIn('object_id', $project->tasks->pluck('id'));
//            $query->where('object_type', 'subtask');
//        });

        $activities = $activityQuery->latest()->paginate(50);
        return view('projects.activities.index', compact('project', 'activities'));
    }
}
