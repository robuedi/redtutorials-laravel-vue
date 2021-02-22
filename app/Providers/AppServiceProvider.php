<?php

namespace App\Providers;

use App\Services\CoursesHierarchy\CoursesHierarchyAdmin;
use App\Services\CoursesHierarchy\CoursesHierarchyAdminInterface;
use App\Services\CoursesService;
use App\Services\CoursesServiceInterface;
use App\Services\Menu\MenuAdmin;
use App\Services\Menu\MenuAdminInterface;
use App\Services\Menu\MenuUserContactMessages;
use App\Services\Menu\MenuUserContactMessagesInterface;
use App\Services\UserProgress\ChapterStatus;
use App\Services\UserProgress\ChapterStatusInterface;
use App\Services\UserProgress\CourseStatus;
use App\Services\UserProgress\CourseStatusInterface;
use App\Services\UserProgress\LessonStatus;
use App\Services\UserProgress\LessonStatusInterface;
use Illuminate\Database\Eloquent\Relations\Relation;
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
        app()->singleton(ChapterStatusInterface::class, ChapterStatus::class);
        app()->singleton(LessonStatusInterface::class, LessonStatus::class);
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
