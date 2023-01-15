<?php


namespace App\Helper;


use Illuminate\Support\Str;
use phpDocumentor\Reflection\DocBlock\Tags\Reference\Url;

class Helper
{
    public static function getProjectStatus(){
        return "Hello world";
    }

    public static function getPercent($total, $part){
        $percent = 0;

        try {
            $percent = round(100 * $part / $total, 2);
        }catch (\DivisionByZeroError $exception){

        }
        return $percent;
    }

    public static function get2Letters($name){
        $words = explode(" ", $name);
        $acronym = "";
        for ($i = 0; $i < count($words); $i++) {
            if ($i < 2)
                $acronym .= strtoupper(mb_substr($words[$i], 0, 1));
            else break;
        }
        return $acronym;
    }

    public static function topbar_avatar($avatar_name, $user_name, $size = "sm"){
        $html = "";
        if ($avatar_name !== "user_default.jpg")
            $html = '<img class="rounded-circle avatar-'.$size.'" src="'.asset('public/images/' . $avatar_name).'"  alt="Header Avatar">';
        else{
            $html = '<div class="avatar-'.$size.' me-0 d-inline-block">'
                .'<div class="avatar-title rounded-circle bg-warning text-white" style="font-size: 15pt">'. self::get2Letters($user_name) .'</div>'
                .'</div>';
        }
        return $html;
    }

    public static function avatar($avatar_name, $user_name, $size = 'avatar-xxs', $font_size = 11, $mine = false){
        $html = "";
        if ($avatar_name !== "user_default.jpg")
            if ($mine)
                $html = '<img data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="'.$user_name.'" class="border-warning border-groove rounded-circle '.$size.'" src="'.asset('public/images/' . $avatar_name).'" alt="Header Avatar">';
            else
                $html = '<img data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="'.$user_name.'" class="rounded-circle '.$size.'" src="'.asset('public/images/' . $avatar_name).'" alt="Header Avatar">';
        else{
            $acronym = self::get2Letters($user_name);
            if ($mine){
                $html = '<div data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="'.$user_name.'" class="'.$size.' me-0 d-inline-block">'
                    .'<div class="avatar-title rounded-circle bg-warning text-white" style="font-size: '.$font_size.'pt">'. $acronym .'</div>'
                    .'</div>';
            }else{
                $html = '<div data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="'.$user_name.'" class="'.$size.' me-0 d-inline-block">'
                    .'<div class="avatar-title rounded-circle bg-secondary text-white" style="font-size: '.$font_size.'pt">'. $acronym .'</div>'
                    .'</div>';
            }
        }
        return $html;
    }

    public static function progress($item){

        $today = date("Y-m-d");

        if ($item->status === "completed"){
            return 100;
        }else if($item->status === 'cancelled'){
           return 0;
        }else if($item->status === 'notyetstarted'){
            return 0;
        }
        else{
            if ($item->end_date){
                if ($today < $item->start_date)
                    return 0;
                if ($today > $item->end_date)
                    return 100;
                if ($today >= $item->start_date && $today <= $item->end_date){
                    $diff = abs(strtotime($today) - strtotime($item->start_date));
                    $years = floor($diff / (365*60*60*24));
                    $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
                    $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
                    $progress = 100 * $days / $item->period;
                    return round($progress, 2);
                }
            }else{
                return -1; // not completed, cancelled without end date
            }
        }

        return 200;
    }

    public static function isNew($created_at){
        $today = date("Y-m-d");
        $diff = abs(strtotime($today) - strtotime($created_at));
        $years = floor($diff / (365*60*60*24));
        $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
        $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
        if ($days < 2)
            return true;

        return false;
    }

    public static function letter_date($date){
        return $date ? date('D j M, Y', strtotime($date)) : "Continue";
    }

    public static function getStatusColor($status){
        return config('constants.status_color')[$status];
    }

    public static function getStatus($type, $status){
        $r = '';
        switch ($type){
            case 0:
                $r = config('constants.big_project_status')[$status];
                break;
            case 1:
                $r = config('constants.project_status')[$status];
                break;
            case 2:
                $r = config('constants.task_status')[$status];
                break;
            default:
        }
        return $r;
    }




    public static function limitString($string, $length){
        return Str::limit($string, $length, $end='...');
    }


    public static function clinicSubTaskEditable($current_user, $sub_task){
        return (
            ($current_user->role == 2) || // super admin
            ($sub_task->leader_id == $current_user->id && $sub_task->department_code == $current_user->department_code) ||
            ($sub_task->leader_id == $current_user->id && $current_user->details->where('type', 2)->where('department_code', $sub_task->department_code)->count()) // department assigned to user by super admin
        );
    }

    public static function clinicSubTaskCreatable($current_user, $task){
        return(
            ($task->leader_id == $current_user->id && $current_user->role == 2) || // super admin
            ($task->leader_id == $current_user->id && $task->department_code == $current_user->department_code) ||
            ($task->leader_id == $current_user->id && $current_user->details->where('type', 2)->where('department_code', $task->department_code)->count()) // department assigned to user by super admin
        );
    }

    public static function clinicTaskEditable($current_user, $task){
        return (
            ($current_user->role == 2) || // super admin
            ($task->leader_id == $current_user->id && $task->department_code == $current_user->department_code) ||
            ($task->leader_id == $current_user->id && $current_user->details->where('type', 2)->where('department_code', $task->department_code)->count()) // department assigned to user by super admin
        );
    }

    public static function clinicTaskCreatable($current_user, $project){
        return(
            ($project->leader_id == $current_user->id && $current_user->role == 2) || // super admin
            ($project->leader_id == $current_user->id && $project->department_code == $current_user->department_code) ||
            ($project->leader_id == $current_user->id && $current_user->details->where('type', 2)->where('department_code', $project->department_code)->count()) // department assigned to user by super admin
        );
    }

    public static function clinicProjectEditable($current_user, $project){
        return (
            ($current_user->role == 2) || // super admin
            ($project->leader_id == $current_user->id && $project->department_code == $current_user->department_code) ||
            ($project->leader_id == $current_user->id && $current_user->details->where('type', 2)->where('department_code', $project->department_code)->count()) // department assigned to user by super admin
        );
    }

    public static function clinicProjectCreatable($current_user, $big_project){
        return(
            ($big_project->boss_id == $current_user->id && $current_user->role == 2) || // super admin
            ($big_project->assignUsers->where('id', $current_user->id)->count() == 1) ||
            ($big_project->boss_id == $current_user->id && $current_user->details->where('type', 2)->where('department_code', $big_project->department_code)->count()) // department assigned to user by super admin
        );
    }

    public static function clinicBigProjectEditable($current_user, $big_project){
        return(
            ($current_user->role == 2) || // super admin
            ($big_project->boss_id == $current_user->id && $current_user->department_code == $big_project->department_code && $current_user->role == 1) || // admin of the department
            ($big_project->boss_id == $current_user->id && $current_user->details->where('type', 2)->where('department_code', $big_project->department_code)->count()) // department assigned to user by super admin
        );
    }

    public static function clinicBigProjectCreatable($current_user, $code){
        return(
            ($current_user->role == 2) || // super admin
            ($current_user->department_code == $code && $current_user->role == 1) || // admin of the department
            ($current_user->details->where('type', 2)->where('department_code', $code)->count()) // department assigned to user by super admin
        );
    }

    public static function statusChangeable($current_user, $object){ // both of clinic and other are been using
        return (
            ($current_user->role == 2) || // super admin
            ($current_user->department_code == $object->department_code && $current_user->role == 1) || // admin of the department
            ($current_user->details->where('type', 3)->where('department_code', $object->department_code)->count()) // department assigned to user by super admin
        );
    }

    public static function otherTaskCreatable($current_user, $code){
        return (
            ($current_user->role == 2)|| // super admin
            ($current_user->department_code == $code && $current_user->role == 1) || // admin of the department
            ($current_user->details->where('type', 2)->where('department_code', $code)->count()) // department assigned to user by super admin
        );
    }

    public static function otherSubTaskCreatable($current_user, $task){
        return (
            ($task->leader_id == $current_user->id && $current_user->role == 2)|| // super admin
            ($task->leader_id == $current_user->id && $current_user->department_code == $task->department_code && $current_user->role == 1) || // admin of the department
            ($task->leader_id == $current_user->id && $current_user->details->where('type', 2)->where('department_code', $task->department_code)->count()) // department assigned to user by super admin
        );
    }

    public static function otherTaskEditable($current_user, $task){
        return (
            ($current_user->role == 2)|| // super admin
            ($task->leader_id == $current_user->id && $current_user->department_code == $task->department_code && $current_user->role == 1) || // admin of the department
            ($task->leader_id == $current_user->id && $current_user->details->where('type', 2)->where('department_code', $task->department_code)->count()) // department assigned to user by super admin
        );
    }

    public static function otherSubTaskEditable($current_user, $subTask){
        return (
            ($current_user->role == 2)|| // super admin
            ($subTask->leader_id == $current_user->id && $current_user->department_code == $subTask->department_code && $current_user->role == 1) || // admin of the department
            ($subTask->leader_id == $current_user->id && $current_user->details->where('type', 2)->where('department_code', $subTask->department_code)->count()) // department assigned to user by super admin
        );
    }

    public static function kpiDataAddable($current_user){
        return(
            ($current_user->role == 2)|| // super admin
            (($current_user->role == 1) && $current_user->assignedKpis->where("user_id", $current_user->id)->count() > 0)
        );
    }

}
