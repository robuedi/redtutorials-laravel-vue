<?php

namespace App\Providers;

use App\Repositories\ChapterRepositoryInterface;
use App\Repositories\ContactMessageUserRepositoryInterface;
use App\Repositories\CourseRepositoryInterface;
use App\Repositories\LessonRepositoryInterface;
use App\Repositories\LessonSectionRepositoryInterface;
use App\Repositories\Repositories\ChapterRepository;
use App\Repositories\Repositories\ContactMessageUserRepository;
use App\Repositories\Repositories\CourseRepository;
use App\Repositories\Repositories\LessonRepository;
use App\Repositories\Repositories\LessonSectionRepository;
use App\Repositories\Repositories\LessonSectionUserRepository;
use App\Repositories\Repositories\StaticPageRepository;
use App\Repositories\StaticPageRepositoryInterface;
use App\Repositories\LessonSectionUserRepositoryInterface;
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
