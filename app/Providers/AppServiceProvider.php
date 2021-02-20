<?php

namespace App\Providers;

use App\Services\CoursesHierarchy\CoursesHierarchyAdmin;
use App\Services\CoursesHierarchy\CoursesHierarchyAdminInterface;
use App\Services\Menu\MenuAdmin;
use App\Services\Menu\MenuAdminInterface;
use App\Services\Menu\MenuUserContactMessages;
use App\Services\Menu\MenuUserContactMessagesInterface;
use App\Services\UserProgress\CourseStatus;
use App\Services\UserProgress\CourseStatusInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        app()->singleton(CoursesHierarchyAdminInterface::class, CoursesHierarchyAdmin::class);
        app()->singleton(MenuUserContactMessagesInterface::class, MenuUserContactMessages::class);
        app()->singleton(MenuAdminInterface::class, MenuAdmin::class);
        app()->singleton(CourseStatusInterface::class, CourseStatus::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
