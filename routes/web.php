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


Route::get('logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);
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


Route::middleware('auth')->group(function () {
    Route::middleware('allowed')->group(function () {
        Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
        Route::get('/notifications/mark_read/{id}', [NotificationController::class, 'mark_read'])->name('notifications.mark_read');

        // Setting
        Route::controller(SettingController::class)->group(function () {
            Route::get('/setting', 'setting')->name('setting');
            Route::post('/updatePassword', 'updatePassword')->name('updatePassword');
            Route::post('/change_avatar', 'change_avatar')->name('change_avatar');
        });

        // Big Projects

        Route::controller(BigProjectController::class)->group(function () {
            Route::get('/biglist/{code}', 'biglist')->name('biglist');
            Route::get('/bigcreate/{code}', 'bigcreate')->name('bigcreate');
            Route::post('/create_big_project', 'create_big_project')->name('create_big_project');
            Route::get('/bigproject/detail/{id}', 'detail')->name('detail');
            Route::get('/bigproject/edit/{id}', 'edit')->name('edit');
            Route::post('/bigproject/edit/{id}', 'p_edit')->name('p_edit');
            Route::post('/bigproject/delete_leader/{id}', 'delete_leader')->name('delete_leader');
            Route::post('/bigproject/delete_manager/{id}', 'delete_manager')->name('delete_manager');
            Route::post('/bigproject/delete_attachment/{id}', 'delete_attachment')->name('delete_attachment');
            Route::post('/bigproject/invite/{id}', 'invite')->name('invite');
            Route::post('/bigproject/invite_manager/{id}', 'invite_manager')->name('invite_manager');
            Route::post('/bigproject/upload_file/{id}', 'upload_file')->name('upload_file');
            Route::post('/bigproject/delete_bigproject/', 'delete_bigproject')->name('delete_bigproject');
            Route::get('/bigproject/chart/{id}', 'chart')->name('chart');
            Route::post('/bigproject/chart/', 'bigproject_chart')->name('bigproject_chart');
            Route::post('/bigproject/m_edit', 'm_edit')->name('m_edit'); // m_ : means modal
            Route::post('/clinic/change_status', 'change_status');
            Route::post('/bigproject/add_comment/{id}', 'add_comment')->name('bigproject.add_comment');
        });

        // Projects
        Route::controller(ProjectController::class)->group(function () {
            Route::get('/projectlist', 'projectlist')->name('projectlist');
            Route::get('/projectcreate', 'projectcreate')->name('projectcreate');
            Route::get('/project/create/{big_project_id}', 'project_create')->name('project_create');
            Route::post('/project/create/{big_project_id}', 'post_project')->name('post_project');
            Route::get('/project/detail/{project_id}', 'project_detail')->name('project_detail');
            Route::get('/project/edit/{project_id}', 'project_edit')->name('project_edit');
            Route::post('/project/edit/{project_id}', 'p_project_edit')->name('p_project_edit');
            Route::post('/project/delete_member/{project_id}', 'delete_member')->name('delete_member');
            Route::post('/project/delete_leader/{project_id}', 'delete_leader')->name('delete_leader');
            Route::post('/project/invite/{project_id}', 'project_member_invite')->name('project_member_invite');
            Route::post('/project/invite_leader/{project_id}', 'project_leader_invite')->name('project_leader_invite');
            Route::post('/project/delete_project', 'delete_project_v2')->name('delete_project_v2');
            Route::post('/project/upload_file/{project_id}', 'project_upload_file')->name('project_upload_file');
            Route::post('/project/delete_attachment/{project_id}', 'project_delete_attachment');
            Route::post('/project/add_comment/{id}', 'add_comment')->name('project.add_comment');
        });


        // Tasks
        Route::controller(TaskController::class)->group(function () {
            Route::get('/tasklist', 'tasklist')->name('tasklist');
            Route::get('/taskcreate', 'taskcreate')->name('taskcreate');
            Route::get('/task/create/{project_id}', 'task_create')->name('task_create');
            Route::post('/task/create/{project_id}', 'p_task_create')->name('p_task_create');
            Route::get('/task/detail/{task_id}', 'task_detail')->name('task_detail');
            Route::get('/task/edit/{task_id}', 'task_edit')->name('task_edit');
            Route::post('/task/edit/{task_id}', 'p_task_edit')->name('p_task_edit');
            Route::post('/task/delete_member/{task_id}', 'task_delete_member')->name('task_delete_member');
            Route::post('/task/delete_leader/{task_id}', 'task_delete_leader')->name('task_delete_leader');
            Route::post('/task/invite/{task_id}', 'task_member_invite')->name('task_member_invite');
            Route::post('/task/invite_leader/{task_id}', 'task_invite_leader')->name('task_invite_leader');
            Route::post('/task/delete_project', 'task_delete_project')->name('task_delete_project');
            Route::post('/task/upload_file/{task_id}', 'task_upload_file')->name('task_upload_file');
            Route::post('/task/delete_attachment/{task_id}', 'task_delete_attachment')->name('task_delete_attachment');
            Route::post('/task/add_comment/{id}', 'add_comment')->name('task.add_comment');
        });

        // Sub Tasks
        Route::controller(SubTaskController::class)->group(function () {
            Route::get('/sublist', 'sublist')->name('sublist');
            Route::get('/subcreate', 'subcreate')->name('subcreate');
            Route::get('/subtask/create/{task_id}', 'sub_task_create')->name('sub_task_create');
            Route::post('/subtask/create/{task_id}', 'p_sub_task_create')->name('p_sub_task_create');
            Route::get('/subtask/detail/{sub_task_id}', 'sub_task_detail')->name('sub_task_detail');
            Route::get('/subtask/edit/{sub_task_id}', 'sub_task_edit')->name('sub_task_edit');
            Route::post('/subtask/edit/{sub_task_id}', 'p_sub_task_edit')->name('p_sub_task_edit');
            Route::post('/subtask/delete_member/{sub_task_id}', 'sub_task_delete_member')->name('sub_task_delete_member');
            Route::post('/subtask/invite/{sub_task_id}', 'sub_task_member_invite')->name('sub_task_member_invite');
            Route::post('/subtask/delete_project', 'sub_task_delete_project')->name('sub_task_delete_project');
            Route::post('/subtask/upload_file/{task_id}', 'sub_task_upload_file')->name('sub_task_upload_file');
            Route::post('/subtask/delete_attachment/{task_id}', 'sub_task_delete_attachment')->name('sub_task_delete_attachment');
            Route::post('/subtask/add_comment/{id}', 'add_comment')->name('subtask.add_comment');
        });


        // Kpi Big Projects
        Route::controller(KpiBigProjectController::class)->group(function () {
            Route::get('/kpibiglist/{code}', 'biglist')->name('kpibiglist');
            Route::get('/kpibigcreate/{code}', 'bigcreate')->name('kpibigcreate');
            Route::post('/create_kpi_big_project', 'create_big_project')->name('create_kpi_big_project');
            Route::get('/kpibigproject/detail/{id}', 'detail')->name('kpidetail');
            Route::post('/kpibigproject/add_comment/{id}', 'add_comment')->name('kpibigproject.add_comment');
            Route::get('/kpibigproject/edit/{id}', 'edit')->name('kpiedit');
            Route::post('/kpibigproject/edit/{id}', 'p_edit')->name('kpi_p_edit');
            Route::post('/kpibigproject/delete_leader/{id}', 'delete_leader')->name('delete_kpi_leader');
            Route::post('/kpibigproject/delete_manager/{id}', 'delete_manager')->name('delete_kpi_manager');
            Route::post('/kpibigproject/delete_attachment/{id}', 'delete_attachment')->name('delete_kpi_attachment');
            Route::post('/kpibigproject/invite/{id}', 'invite')->name('kpi_invite');
            Route::post('/kpibigproject/invite_manager/{id}', 'invite_manager')->name('kpi_invite_manager');
            Route::post('/kpibigproject/upload_file/{id}', 'upload_file')->name('kpi_upload_file');
            Route::post('/kpibigproject/delete_bigproject/', 'delete_bigproject')->name('delete_kpibigproject');
            Route::get('/kpibigproject/chart/{id}', 'chart')->name('kpichart');
            Route::post('/kpibigproject/chart/', 'bigproject_chart')->name('kpibigproject_chart');
            Route::post('/kpibigproject/m_edit', 'm_edit')->name('kpi_m_edit'); // m_ : means modal
            Route::post('/clinic/change_status', 'change_status');
        });

        // Kpi Projects
        Route::controller(KpiProjectController::class)->group(function () {
            Route::get('/kpiprojectlist', 'projectlist')->name('kpiprojectlist');
            Route::get('/kpiprojectcreate', 'projectcreate')->name('kpiprojectcreate');
            Route::get('/kpiproject/create/{big_project_id}', 'project_create')->name('kpiproject_create');
            Route::post('/kpiproject/create/{big_project_id}', 'post_project')->name('post_kpiproject');
            Route::get('/kpiproject/detail/{project_id}', 'project_detail')->name('kpiproject_detail');
            Route::get('/kpiproject/edit/{project_id}', 'project_edit')->name('kpiproject_edit');
            Route::post('/kpiproject/edit/{project_id}', 'p_project_edit')->name('p_kpiproject_edit');
            Route::post('/kpiproject/delete_member/{project_id}', 'delete_member')->name('delete_kpi_member');
            Route::post('/kpiproject/delete_leader/{project_id}', 'delete_leader')->name('delete_kpi_leader');
            Route::post('/kpiproject/invite/{project_id}', 'project_member_invite')->name('kpiproject_member_invite');
            Route::post('/kpiproject/invite_leader/{project_id}', 'project_leader_invite')->name('kpiproject_leader_invite');
            Route::post('/kpiproject/delete_project', 'delete_project_v2')->name('delete_kpiproject_v2');
            Route::post('/kpiproject/upload_file/{project_id}', 'project_upload_file')->name('kpiproject_upload_file');
            Route::post('/kpiproject/delete_attachment/{project_id}', 'kpiproject_delete_attachment');
            Route::post('/kpiproject/add_comment/{id}', 'add_comment')->name('kpiproject.add_comment');
        });

        // Kpi Tasks
        Route::controller(KpiTaskController::class)->group(function () {
            Route::get('/kpitasklist', 'tasklist')->name('kpitasklist');
            Route::get('/kpitaskcreate', 'taskcreate')->name('kpitaskcreate');
            Route::get('/kpitask/create/{project_id}', 'task_create')->name('kpitask_create');
            Route::post('/kpitask/create/{project_id}', 'p_task_create')->name('p_kpitask_create');
            Route::get('/kpitask/detail/{task_id}', 'task_detail')->name('kpitask_detail');
            Route::get('/kpitask/edit/{task_id}', 'task_edit')->name('kpitask_edit');
            Route::post('/kpitask/edit/{task_id}', 'p_task_edit')->name('p_kpitask_edit');
            Route::post('/kpitask/delete_member/{task_id}', 'task_delete_member')->name('kpitask_delete_member');
            Route::post('/kpitask/delete_leader/{task_id}', 'task_delete_leader')->name('kpitask_delete_leader');
            Route::post('/kpitask/invite/{task_id}', 'task_member_invite')->name('kpitask_member_invite');
            Route::post('/kpitask/invite_leader/{task_id}', 'task_leader_invite')->name('kpitask_leader_invite');
            Route::post('/kpitask/delete_project', 'task_delete_project')->name('kpitask_delete_project');
            Route::post('/kpitask/upload_file/{task_id}', 'task_upload_file')->name('kpitask_upload_file');
            Route::post('/kpitask/delete_attachment/{task_id}', 'task_delete_attachment')->name('kpitask_delete_attachment');
            Route::post('/kpitask/add_comment/{id}', 'add_comment')->name('kpitask.add_comment');
        });

        // Sub Tasks
        Route::controller(KpiSubTaskController::class)->group(function () {
            Route::get('/kpisublist', 'sublist')->name('kpisublist');
            Route::get('/kpisubcreate', 'subcreate')->name('kpisubcreate');
            Route::get('/kpisubtask/create/{task_id}', 'sub_task_create')->name('kpisub_task_create');
            Route::post('/kpisubtask/create/{task_id}', 'p_sub_task_create')->name('p_kpisub_task_create');
            Route::get('/kpisubtask/detail/{sub_task_id}', 'sub_task_detail')->name('kpisub_task_detail');
            Route::get('/kpisubtask/edit/{sub_task_id}', 'sub_task_edit')->name('kpisub_task_edit');
            Route::post('/kpisubtask/edit/{sub_task_id}', 'p_sub_task_edit')->name('p_kpisub_task_edit');
            Route::post('/kpisubtask/delete_member/{sub_task_id}', 'sub_task_delete_member')->name('kpisub_task_delete_member');
            Route::post('/kpisubtask/invite/{sub_task_id}', 'sub_task_member_invite')->name('kpisub_task_member_invite');
            Route::post('/kpisubtask/delete_project', 'sub_task_delete_project')->name('kpisub_task_delete_project');
            Route::post('/kpisubtask/upload_file/{task_id}', 'sub_task_upload_file')->name('kpisub_task_upload_file');
            Route::post('/kpisubtask/delete_attachment/{task_id}', 'sub_task_delete_attachment')->name('kpisub_task_delete_attachment');
            Route::post('/kpisubtask/add_comment/{id}', 'add_comment')->name('kpisubtask.add_comment');
        });



        // other department
        Route::prefix('/tasks')->group(function () {

            // task
            Route::controller(OtherDepartmentController::class)->group(function () {
                Route::get('/{code}', 'tasks')->name('tasks');
                Route::get('/detail/{id}', 'detail')->name('task.detail');
                Route::post('/create', 'create')->name('task.create');
                Route::post('/invite', 'invite')->name('task.invite');
                Route::post('/delete_member', 'delete_member')->name('task.delete_member');
                Route::post('/edit', 'edit')->name('task.edit');
                Route::post('/upload_file', 'upload_file')->name('task.upload_file');
                Route::post('/delete_attachment', 'delete_attachment')->name('task.delete_attachment');
                Route::post('/change_status', 'change_status')->name('task.change_status');
            });


            // sub task
            Route::controller(OtherSubDepartmentController::class)->group(function () {
                Route::post('/sub_create', 'sub_create')->name('task.sub_create');
                Route::get('/sub_detail/{id}', 'sub_detail')->name('task.sub_detail');
                Route::post('/sub_invite', 'sub_invite')->name('task.sub_invite');
                Route::post('/sub_delete_member', 'sub_delete_member')->name('task.sub_delete_member');
                Route::post('/sub_edit', 'sub_edit')->name('task.sub_edit');
                Route::post('/sub_upload_file', 'sub_upload_file')->name('task.sub_upload_file');
                Route::post('/sub_delete_attachment', 'sub_delete_attachment')->name('task.sub_delete_attachment');
                Route::post('/sub_change_status', 'sub_change_status')->name('task.sub_change_status');
            });
        });


        Route::middleware('role:super')->group(function () {
            Route::prefix('/admin')->controller(UsermanagementController::class)->group(function () {
                // User Management
                Route::get('/usermanagement', 'usermanagement')->name('usermanagement');
                Route::post('/usermanagement', 'setboss')->name('setboss');
                Route::get('/allowed', 'allowed')->name('allowed');
                Route::post('/remove_user', 'remove_user')->name('remove_user');
                Route::post('/change_detail', 'change_detail');
                Route::post('/change_assign_kpi', 'change_assign_kpi');
                Route::get('/users/{id}', 'user_detail');
                // Department Management
                Route::get('/chart', 'chart');
            });

            Route::prefix('kpi')->controller(KpiSettingController::class)->group(function () {
                Route::get('/setting', 'setting')->withoutMiddleware("role:super");
                Route::post('/add_group', 'add_group')->withoutMiddleware("role:super");
                Route::post('/edit_gu', 'edit_gu')->withoutMiddleware("role:super");
                Route::post('/delete_gu', 'delete_gu')->withoutMiddleware("role:super");
                Route::post('/add_unit', 'add_unit')->withoutMiddleware("role:super");
                Route::get("/add", "kpi_list")->withoutMiddleware("role:super");
                Route::post("/add_kpi", "add_kpi")->withoutMiddleware("role:super");
                Route::post("/delete_kpi", "delete_kpi")->withoutMiddleware("role:super");
                Route::post("/edit_kpi", "edit_kpi")->withoutMiddleware("role:super");
                Route::get("/add_kpi_data", "add_kpi_data")->withoutMiddleware("role:super");
                Route::post("/get_kpi_data", "get_kpi_data")->withoutMiddleware("role:super");
                Route::post("/update_kpi_data", "update_kpi_data")->withoutMiddleware("role:super");
                Route::get("/charts", "charts")->withoutMiddleware("role:super");
                Route::post("/update_kpi_chart", "update_kpi_chart")->withoutMiddleware("role:super");
            });
        });
    });
});


Route::get('/clear', function () {
    Artisan::call('cache:clear');
    Artisan::call('config:cache');
    Artisan::call('view:clear');
    Artisan::call('view:cache');
    Artisan::call('route:clear');
    return "Cache is cleared";
});

Route::get('/qrcode', [QrCodeController::class, 'index']);
