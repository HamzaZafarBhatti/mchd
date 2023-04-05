<?php

namespace App\Providers;

use App\Models\Department;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
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
        Paginator::useBootstrapFive();
        $departments = Department::all();
        View::share('departments', $departments);
        View::composer('*', function ($view) {
            $notifications = array();
            if (Auth::check()) {
                $user = User::find(Auth::user()->id);
                $notifications = $user->notifications()->wherePivot('is_read', 0)->orderBy('id', 'desc')->/* take(5)-> */get();
            }
            $view->with('notifications', $notifications);
        });
        Schema::defaultStringLength(191);
    }
}
