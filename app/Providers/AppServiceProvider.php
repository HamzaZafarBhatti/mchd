<?php

namespace App\Providers;

use App\Models\Department;
use App\Models\Notification;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $departments = Department::all();
        View::share('departments', $departments);
        $notifications = array();
        if(Schema::hasTable('notifications')) {
            $notifications = Notification::where('is_read', 0)->latest()->take(5)->get();
        }
        View::share('notifications', $notifications);
        Schema::defaultStringLength(191);
    }
}
