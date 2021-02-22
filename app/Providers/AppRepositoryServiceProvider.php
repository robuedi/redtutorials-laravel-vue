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
use App\Repositories\LessonSectionRepository;
use App\Repositories\LessonSectionRepositoryInterface;
use App\Repositories\StaticPageRepository;
use App\Repositories\StaticPageRepositoryInterface;
use App\Repositories\LessonSectionUserRepositoryInterface;
use App\Repositories\LessonSectionUserRepository;
use Illuminate\Support\ServiceProvider;

class AppRepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //repositories
        app()->singleton(CourseRepositoryInterface::class, CourseRepository::class);
        app()->singleton(ChapterRepositoryInterface::class, ChapterRepository::class);
        app()->singleton(LessonRepositoryInterface::class, LessonRepository::class);
        app()->bind(LessonRepositoryInterface::class, LessonRepository::class);
        app()->singleton(ContactMessageUserRepositoryInterface::class, ContactMessageUserRepository::class);
        app()->singleton(LessonSectionUserRepositoryInterface::class, LessonSectionUserRepository::class);
        app()->singleton(StaticPageRepositoryInterface::class, StaticPageRepository::class);
        app()->singleton(LessonSectionRepositoryInterface::class, LessonSectionRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
