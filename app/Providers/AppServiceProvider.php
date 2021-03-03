<?php

namespace App\Providers;

use App\Services\CoursesHierarchy\CoursesHierarchyAdmin;
use App\Services\CoursesHierarchy\CoursesHierarchyAdminInterface;
use App\Services\ItemsStatusFlagService;
use App\Services\ItemsStatusFlagServiceInterface;
use App\Services\Menu\MenuAdmin;
use App\Services\Menu\MenuAdminInterface;
use App\Services\Menu\MenuUserContactMessages;
use App\Services\Menu\MenuUserContactMessagesInterface;
use App\Services\NumericService;
use App\Services\NumericServiceInterface;
use App\Services\Progress\Chapter\ChapterProgress;
use App\Services\Progress\Chapter\ChapterProgressInterface;
use App\Services\Progress\Course\CourseProgress;
use App\Services\Progress\Course\CourseProgressInterface;
use App\Services\Progress\Lesson\LessonProgress;
use App\Services\Progress\LessonProgressInterface;
use App\Services\Progress\LessonSection\LessonSectionProgress;
use App\Services\Progress\LessonSectionProgressInterface;
use App\Services\Progress\Progress;
use App\Services\SEO\MetaDescriptionServiceInterface;
use App\Services\SEO\MetaDescriptionService;
use App\Services\UserProgress\ChapterStatus;
use App\Services\UserProgress\ChapterStatusInterface;
use App\Services\UserProgress\CourseStatus;
use App\Services\UserProgress\CourseStatusInterface;
use App\Services\UserProgress\LessonStatus;
use App\Services\UserProgress\LessonStatusInterface;
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
        app()->singleton(MetaDescriptionServiceInterface::class, MetaDescriptionService::class);
        app()->singleton(NumericServiceInterface::class, NumericService::class);
        app()->singleton(ItemsStatusFlagServiceInterface::class, ItemsStatusFlagService::class);

        //Progress - Decorator Design Pattern
        app()->singleton(LessonSectionProgressInterface::class, LessonSectionProgress::class);
        app()->singleton(LessonProgressInterface::class, LessonProgress::class);
        app()->singleton(ChapterProgressInterface::class, ChapterProgress::class);
        app()->singleton(CourseProgressInterface::class, CourseProgress::class);

        app()->when(LessonProgress::class)
            ->needs(Progress::class)
            ->give(LessonSectionProgress::class);

        app()->when(ChapterProgress::class)
            ->needs(Progress::class)
            ->give(LessonProgress::class);

        app()->when(CourseProgress::class)
            ->needs(Progress::class)
            ->give(ChapterProgress::class);
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
