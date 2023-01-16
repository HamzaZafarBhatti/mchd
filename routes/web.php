<?php

use App\Http\Controllers\BigProjectController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KpiBigProjectController;
use App\Http\Controllers\KpiProjectController;
use App\Http\Controllers\KpiSettingController;
use App\Http\Controllers\KpiSubTaskController;
use App\Http\Controllers\KpiTaskController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OtherDepartmentController;
use App\Http\Controllers\OtherSubDepartmentController;
use App\Http\Controllers\QrCodeController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SubTaskController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UsermanagementController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Http\Controllers\ProjectController;

Auth::routes();
//Language Translation
Route::get('index/{locale}', [App\Http\Controllers\HomeController::class, 'lang']);

//Update User Details
Route::post('/update-profile/{id}', [App\Http\Controllers\HomeController::class, 'updateProfile'])->name('updateProfile');
Route::post('/update-password/{id}', [App\Http\Controllers\HomeController::class, 'updatePassword'])->name('updatePassword');

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/dashboard/{id}', [DashboardController::class, 'dashboard']);


// notification route
Route::patch('/fcm-token', [NotificationController::class, 'updateToken'])->name('fcmToken');
Route::get('/send-notification', [NotificationController::class, 'notification']);


Route::middleware('auth')->group(function (){
    Route::middleware('allowed')->group(function (){

        // Setting
        Route::get('/setting', [SettingController::class, 'setting'])->name('setting');
        Route::post('/updatePassword', [SettingController::class, 'updatePassword'])->name('updatePassword');
        Route::post('/change_avatar', [SettingController::class, 'change_avatar'])->name('change_avatar');

        // Big Projects
        Route::get('/biglist/{code}', [BigProjectController::class, 'biglist'])->name('biglist');
        Route::get('/bigcreate/{code}', [BigProjectController::class, 'bigcreate'])->name('bigcreate');
        Route::post('/create_big_project', [BigProjectController::class, 'create_big_project'])->name('create_big_project');
        Route::get('/bigproject/detail/{id}', [BigProjectController::class, 'detail'])->name('detail');
        Route::get('/bigproject/edit/{id}', [BigProjectController::class, 'edit'])->name('edit');
        Route::post('/bigproject/edit/{id}', [BigProjectController::class, 'p_edit'])->name('p_edit');
        Route::post('/bigproject/delete_leader/{id}', [BigProjectController::class, 'delete_leader'])->name('delete_leader');
        Route::post('/bigproject/delete_attachment/{id}', [BigProjectController::class, 'delete_attachment'])->name('delete_attachment');
        Route::post('/bigproject/invite/{id}', [BigProjectController::class, 'invite'])->name('invite');
        Route::post('/bigproject/upload_file/{id}', [BigProjectController::class, 'upload_file'])->name('upload_file');
        Route::post('/bigproject/delete_bigproject/', [BigProjectController::class, 'delete_bigproject'])->name('delete_bigproject');
        Route::get('/bigproject/chart/{id}', [BigProjectController::class, 'chart'])->name('chart');
        Route::post('/bigproject/chart/', [BigProjectController::class, 'bigproject_chart'])->name('bigproject_chart');
        Route::post('/bigproject/m_edit', [BigProjectController::class, 'm_edit'])->name('m_edit'); // m_ : means modal
        Route::post('/clinic/change_status', [BigProjectController::class, 'change_status']);

        // Projects
        Route::get('/projectlist', [ProjectController::class, 'projectlist'])->name('projectlist');
        Route::get('/projectcreate', [ProjectController::class, 'projectcreate'])->name('projectcreate');
        Route::get('/project/create/{big_project_id}', [ProjectController::class, 'project_create'])->name('project_create');
        Route::post('/project/create/{big_project_id}', [ProjectController::class, 'post_project'])->name('post_project');
        Route::get('/project/detail/{project_id}', [ProjectController::class, 'project_detail'])->name('project_detail');
        Route::get('/project/edit/{project_id}', [ProjectController::class, 'project_edit'])->name('project_edit');
        Route::post('/project/edit/{project_id}', [ProjectController::class, 'p_project_edit'])->name('p_project_edit');
        Route::post('/project/delete_member/{project_id}', [ProjectController::class, 'delete_member'])->name('delete_member');
        Route::post('/project/invite/{project_id}', [ProjectController::class, 'project_member_invite'])->name('project_member_invite');
        Route::post('/project/delete_project', [ProjectController::class, 'delete_project_v2'])->name('delete_project_v2');
        Route::post('/project/upload_file/{project_id}', [ProjectController::class, 'project_upload_file'])->name('project_upload_file');
        Route::post('/project/delete_attachment/{project_id}', [ProjectController::class, 'project_delete_attachment']);


        // Tasks
        Route::get('/tasklist', [TaskController::class, 'tasklist'])->name('tasklist');
        Route::get('/taskcreate', [TaskController::class, 'taskcreate'])->name('taskcreate');
        Route::get('/task/create/{project_id}', [TaskController::class, 'task_create'])->name('task_create');
        Route::post('/task/create/{project_id}', [TaskController::class, 'p_task_create'])->name('p_task_create');
        Route::get('/task/detail/{task_id}', [TaskController::class, 'task_detail'])->name('task_detail');
        Route::get('/task/edit/{task_id}', [TaskController::class, 'task_edit'])->name('task_edit');
        Route::post('/task/edit/{task_id}', [TaskController::class, 'p_task_edit'])->name('p_task_edit');
        Route::post('/task/delete_member/{task_id}', [TaskController::class, 'task_delete_member'])->name('task_delete_member');
        Route::post('/task/invite/{task_id}', [TaskController::class, 'task_member_invite'])->name('task_member_invite');
        Route::post('/task/delete_project', [TaskController::class, 'task_delete_project'])->name('task_delete_project');
        Route::post('/task/upload_file/{task_id}', [TaskController::class, 'task_upload_file'])->name('task_upload_file');
        Route::post('/task/delete_attachment/{task_id}', [TaskController::class, 'task_delete_attachment'])->name('task_delete_attachment');

        // Sub Tasks
        Route::get('/sublist', [SubTaskController::class, 'sublist'])->name('sublist');
        Route::get('/subcreate', [SubTaskController::class, 'subcreate'])->name('subcreate');
        Route::get('/subtask/create/{task_id}', [SubTaskController::class, 'sub_task_create'])->name('sub_task_create');
        Route::post('/subtask/create/{task_id}', [SubTaskController::class, 'p_sub_task_create'])->name('p_sub_task_create');
        Route::get('/subtask/detail/{sub_task_id}', [SubTaskController::class, 'sub_task_detail'])->name('sub_task_detail');
        Route::get('/subtask/edit/{sub_task_id}', [SubTaskController::class, 'sub_task_edit'])->name('sub_task_edit');
        Route::post('/subtask/edit/{sub_task_id}', [SubTaskController::class, 'p_sub_task_edit'])->name('p_sub_task_edit');
        Route::post('/subtask/delete_member/{sub_task_id}', [SubTaskController::class, 'sub_task_delete_member'])->name('sub_task_delete_member');
        Route::post('/subtask/invite/{sub_task_id}', [SubTaskController::class, 'sub_task_member_invite'])->name('sub_task_member_invite');
        Route::post('/subtask/delete_project', [SubTaskController::class, 'sub_task_delete_project'])->name('sub_task_delete_project');
        Route::post('/subtask/upload_file/{task_id}', [SubTaskController::class, 'sub_task_upload_file'])->name('sub_task_upload_file');
        Route::post('/subtask/delete_attachment/{task_id}', [SubTaskController::class, 'sub_task_delete_attachment'])->name('sub_task_delete_attachment');

        
        // Kpi Big Projects
        Route::get('/kpibiglist/{code}', [KpiBigProjectController::class, 'biglist'])->name('kpibiglist');
        Route::get('/kpibigcreate/{code}', [KpiBigProjectController::class, 'bigcreate'])->name('kpibigcreate');
        Route::post('/create_kpi_big_project', [KpiBigProjectController::class, 'create_big_project'])->name('create_kpi_big_project');
        Route::get('/kpibigproject/detail/{id}', [KpiBigProjectController::class, 'detail'])->name('kpidetail');
        Route::get('/kpibigproject/edit/{id}', [KpiBigProjectController::class, 'edit'])->name('kpiedit');
        Route::post('/kpibigproject/edit/{id}', [KpiBigProjectController::class, 'p_edit'])->name('kpi_p_edit');
        Route::post('/kpibigproject/delete_leader/{id}', [KpiBigProjectController::class, 'delete_leader'])->name('delete_kpi_leader');
        Route::post('/kpibigproject/delete_attachment/{id}', [KpiBigProjectController::class, 'delete_attachment'])->name('delete_kpi_attachment');
        Route::post('/kpibigproject/invite/{id}', [KpiBigProjectController::class, 'invite'])->name('kpi_invite');
        Route::post('/kpibigproject/upload_file/{id}', [KpiBigProjectController::class, 'upload_file'])->name('kpi_upload_file');
        Route::post('/kpibigproject/delete_bigproject/', [KpiBigProjectController::class, 'delete_bigproject'])->name('delete_kpibigproject');
        Route::get('/kpibigproject/chart/{id}', [KpiBigProjectController::class, 'chart'])->name('kpichart');
        Route::post('/kpibigproject/chart/', [KpiBigProjectController::class, 'bigproject_chart'])->name('kpibigproject_chart');
        Route::post('/kpibigproject/m_edit', [KpiBigProjectController::class, 'm_edit'])->name('kpi_m_edit'); // m_ : means modal
        Route::post('/clinic/change_status', [KpiBigProjectController::class, 'change_status']);

        // Kpi Projects
        Route::get('/kpiprojectlist', [KpiProjectController::class, 'projectlist'])->name('kpiprojectlist');
        Route::get('/kpiprojectcreate', [KpiProjectController::class, 'projectcreate'])->name('kpiprojectcreate');
        Route::get('/kpiproject/create/{big_project_id}', [KpiProjectController::class, 'project_create'])->name('kpiproject_create');
        Route::post('/kpiproject/create/{big_project_id}', [KpiProjectController::class, 'post_project'])->name('post_kpiproject');
        Route::get('/kpiproject/detail/{project_id}', [KpiProjectController::class, 'project_detail'])->name('kpiproject_detail');
        Route::get('/kpiproject/edit/{project_id}', [KpiProjectController::class, 'project_edit'])->name('kpiproject_edit');
        Route::post('/kpiproject/edit/{project_id}', [KpiProjectController::class, 'p_project_edit'])->name('p_kpiproject_edit');
        Route::post('/kpiproject/delete_member/{project_id}', [KpiProjectController::class, 'delete_member'])->name('delete_kpi_member');
        Route::post('/kpiproject/invite/{project_id}', [KpiProjectController::class, 'project_member_invite'])->name('kpiproject_member_invite');
        Route::post('/kpiproject/delete_project', [KpiProjectController::class, 'delete_project_v2'])->name('delete_kpiproject_v2');
        Route::post('/kpiproject/upload_file/{project_id}', [KpiProjectController::class, 'project_upload_file'])->name('kpiproject_upload_file');
        Route::post('/kpiproject/delete_attachment/{project_id}', [KpiProjectController::class, 'kpiproject_delete_attachment']);

        // Kpi Tasks
        Route::get('/kpitasklist', [KpiTaskController::class, 'tasklist'])->name('kpitasklist');
        Route::get('/kpitaskcreate', [KpiTaskController::class, 'taskcreate'])->name('kpitaskcreate');
        Route::get('/kpitask/create/{project_id}', [KpiTaskController::class, 'task_create'])->name('kpitask_create');
        Route::post('/kpitask/create/{project_id}', [KpiTaskController::class, 'p_task_create'])->name('p_kpitask_create');
        Route::get('/kpitask/detail/{task_id}', [KpiTaskController::class, 'task_detail'])->name('kpitask_detail');
        Route::get('/kpitask/edit/{task_id}', [KpiTaskController::class, 'task_edit'])->name('kpitask_edit');
        Route::post('/kpitask/edit/{task_id}', [KpiTaskController::class, 'p_task_edit'])->name('p_kpitask_edit');
        Route::post('/kpitask/delete_member/{task_id}', [KpiTaskController::class, 'task_delete_member'])->name('kpitask_delete_member');
        Route::post('/kpitask/invite/{task_id}', [KpiTaskController::class, 'task_member_invite'])->name('kpitask_member_invite');
        Route::post('/kpitask/delete_project', [KpiTaskController::class, 'task_delete_project'])->name('kpitask_delete_project');
        Route::post('/kpitask/upload_file/{task_id}', [KpiTaskController::class, 'task_upload_file'])->name('kpitask_upload_file');
        Route::post('/kpitask/delete_attachment/{task_id}', [KpiTaskController::class, 'task_delete_attachment'])->name('kpitask_delete_attachment');

        // Sub Tasks
        Route::get('/kpisublist', [KpiSubTaskController::class, 'sublist'])->name('kpisublist');
        Route::get('/kpisubcreate', [KpiSubTaskController::class, 'subcreate'])->name('kpisubcreate');
        Route::get('/kpisubtask/create/{task_id}', [KpiSubTaskController::class, 'sub_task_create'])->name('kpisub_task_create');
        Route::post('/kpisubtask/create/{task_id}', [KpiSubTaskController::class, 'p_sub_task_create'])->name('p_kpisub_task_create');
        Route::get('/kpisubtask/detail/{sub_task_id}', [KpiSubTaskController::class, 'sub_task_detail'])->name('kpisub_task_detail');
        Route::get('/kpisubtask/edit/{sub_task_id}', [KpiSubTaskController::class, 'sub_task_edit'])->name('kpisub_task_edit');
        Route::post('/kpisubtask/edit/{sub_task_id}', [KpiSubTaskController::class, 'p_sub_task_edit'])->name('p_kpisub_task_edit');
        Route::post('/kpisubtask/delete_member/{sub_task_id}', [KpiSubTaskController::class, 'sub_task_delete_member'])->name('kpisub_task_delete_member');
        Route::post('/kpisubtask/invite/{sub_task_id}', [KpiSubTaskController::class, 'sub_task_member_invite'])->name('kpisub_task_member_invite');
        Route::post('/kpisubtask/delete_project', [KpiSubTaskController::class, 'sub_task_delete_project'])->name('kpisub_task_delete_project');
        Route::post('/kpisubtask/upload_file/{task_id}', [KpiSubTaskController::class, 'sub_task_upload_file'])->name('kpisub_task_upload_file');
        Route::post('/kpisubtask/delete_attachment/{task_id}', [KpiSubTaskController::class, 'sub_task_delete_attachment'])->name('kpisub_task_delete_attachment');



        // other department
        Route::prefix('/tasks')->group(function (){

            // task
            Route::get('/{code}', [OtherDepartmentController::class, 'tasks'])->name('tasks');
            Route::get('/detail/{id}', [OtherDepartmentController::class, 'detail'])->name('task.detail');
            Route::post('/create', [OtherDepartmentController::class, 'create'])->name('task.create');
            Route::post('/invite', [OtherDepartmentController::class, 'invite'])->name('task.invite');
            Route::post('/delete_member', [OtherDepartmentController::class, 'delete_member'])->name('task.delete_member');
            Route::post('/edit', [OtherDepartmentController::class, 'edit'])->name('task.edit');
            Route::post('/upload_file', [OtherDepartmentController::class, 'upload_file'])->name('task.upload_file');
            Route::post('/delete_attachment', [OtherDepartmentController::class, 'delete_attachment'])->name('task.delete_attachment');
            Route::post('/change_status', [OtherDepartmentController::class, 'change_status'])->name('task.change_status');


            // sub task
            Route::post('/sub_create', [OtherSubDepartmentController::class, 'sub_create'])->name('task.sub_create');
            Route::get('/sub_detail/{id}', [OtherSubDepartmentController::class, 'sub_detail'])->name('task.sub_detail');
            Route::post('/sub_invite', [OtherSubDepartmentController::class, 'sub_invite'])->name('task.sub_invite');
            Route::post('/sub_delete_member', [OtherSubDepartmentController::class, 'sub_delete_member'])->name('task.sub_delete_member');
            Route::post('/sub_edit', [OtherSubDepartmentController::class, 'sub_edit'])->name('task.sub_edit');
            Route::post('/sub_upload_file', [OtherSubDepartmentController::class, 'sub_upload_file'])->name('task.sub_upload_file');
            Route::post('/sub_delete_attachment', [OtherSubDepartmentController::class, 'sub_delete_attachment'])->name('task.sub_delete_attachment');
            Route::post('/sub_change_status', [OtherSubDepartmentController::class, 'sub_change_status'])->name('task.sub_change_status');
        });


        Route::middleware('role:super')->group(function (){
            Route::prefix('/admin')->group(function (){
                // User Management
                Route::get('/usermanagement', [UsermanagementController::class, 'usermanagement'])->name('usermanagement');
                Route::post('/usermanagement', [UsermanagementController::class, 'setboss'])->name('setboss');
                Route::get('/allowed', [UsermanagementController::class, 'allowed'])->name('allowed');
                Route::post('/remove_user', [UsermanagementController::class, 'remove_user'])->name('remove_user');
                Route::post('/change_detail', [UsermanagementController::class, 'change_detail']);
                Route::post('/change_assign_kpi', [UsermanagementController::class, 'change_assign_kpi']);
                Route::get('/users/{id}', [UsermanagementController::class, 'user_detail']);
                // Department Management
                Route::get('/chart', [UsermanagementController::class, 'chart']);
            });

            Route::prefix('kpi')->group(function (){
                Route::controller(KpiSettingController::class)->group(function () {
                    Route::get('/setting', 'setting')->withoutMiddleware("role:super");;
                    Route::post('/add_group', 'add_group')->withoutMiddleware("role:super");;
                    Route::post('/edit_gu', 'edit_gu')->withoutMiddleware("role:super");;
                    Route::post('/delete_gu', 'delete_gu')->withoutMiddleware("role:super");;
                    Route::post('/add_unit', 'add_unit')->withoutMiddleware("role:super");;
                    Route::get("/add", "kpi_list")->withoutMiddleware("role:super");;
                    Route::post("/add_kpi", "add_kpi")->withoutMiddleware("role:super");;
                    Route::post("/delete_kpi", "delete_kpi")->withoutMiddleware("role:super");;
                    Route::post("/edit_kpi", "edit_kpi")->withoutMiddleware("role:super");;
                    Route::get("/add_kpi_data", "add_kpi_data")->withoutMiddleware("role:super");;
                    Route::post("/get_kpi_data", "get_kpi_data")->withoutMiddleware("role:super");;
                    Route::post("/update_kpi_data", "update_kpi_data")->withoutMiddleware("role:super");;
                    Route::get("/charts", "charts")->withoutMiddleware("role:super");
                    Route::post("/update_kpi_chart", "update_kpi_chart")->withoutMiddleware("role:super");;
                });
            });
        });
    });
});


Route::get('/clear', function() {
    Artisan::call('cache:clear');
    Artisan::call('config:cache');
    Artisan::call('view:clear');
    Artisan::call('view:cache');
    Artisan::call('route:clear');
    return "Cache is cleared";
});

Route::get('/qrcode', [QrCodeController::class, 'index']);

