<?php

namespace App\Providers;

use App\Services\CoursesHierarchy\CoursesHierarchyAdmin;
use App\Services\CoursesHierarchy\CoursesHierarchyAdminInterface;
use App\Services\ItemsStatusFlag\ItemsStatusFlag;
use App\Services\ItemsStatusFlag\ItemsStatusFlagInterface;
use App\Services\Menu\MenuAdmin;
use App\Services\Menu\MenuAdminInterface;
use App\Services\Menu\MenuUserContactMessages;
use App\Services\Menu\MenuUserContactMessagesInterface;
use App\Services\NumericHelper\NumericHelper;
use App\Services\NumericHelper\NumericHelperInterface;
use App\Services\Progress\ChapterProgressInterface;
use App\Services\Progress\CourseComponents\ChapterProgress;
use App\Services\Progress\CourseComponents\CourseProgress;
use App\Services\Progress\CourseComponents\LessonProgress;
use App\Services\Progress\CourseComponents\LessonSectionProgress;
use App\Services\Progress\CourseProgressInterface;
use App\Services\Progress\Decorator\Progress;
use App\Services\Progress\LessonProgressInterface;
use App\Services\Progress\LessonSectionProgressInterface;
use App\Services\SEO\MetaDescriptionServiceInterface;
use App\Services\SEO\MetaDescriptionService;
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
        app()->singleton(MetaDescriptionServiceInterface::class, MetaDescriptionService::class);
        app()->singleton(NumericHelperInterface::class, NumericHelper::class);
        app()->singleton(ItemsStatusFlagInterface::class, ItemsStatusFlag::class);

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
