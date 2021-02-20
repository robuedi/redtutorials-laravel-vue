<?php

namespace App\Providers;

use App\Repositories\ChapterRepository;
use App\Repositories\ChapterRepositoryInterface;
use App\Repositories\ContactMessageUserRepository;
use App\Repositories\ContactMessageUserRepositoryInterface;
use App\Repositories\CourseRepository;
use App\Repositories\CourseRepositoryInterface;
use App\Repositories\LessonRepository;
use App\Repositories\LessonRepositoryInterface;
use App\Services\CoursesHierarchy\CoursesHierarchyAdmin;
use App\Services\CoursesHierarchy\CoursesHierarchyAdminInterface;
use App\Services\Menu\MenuAdmin;
use App\Services\Menu\MenuAdminInterface;
use App\Services\Menu\MenuUserContactMessages;
use App\Services\Menu\MenuUserContactMessagesInterface;
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
        //repositories
        app()->singleton(CourseRepositoryInterface::class, CourseRepository::class);
        app()->singleton(ChapterRepositoryInterface::class, ChapterRepository::class);
        app()->singleton(LessonRepositoryInterface::class, LessonRepository::class);
        app()->singleton(ContactMessageUserRepositoryInterface::class, ContactMessageUserRepository::class);

        app()->singleton(CoursesHierarchyAdminInterface::class, CoursesHierarchyAdmin::class);
        app()->singleton(MenuUserContactMessagesInterface::class, MenuUserContactMessages::class);
        app()->singleton(MenuAdminInterface::class, MenuAdmin::class);
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
