<?php

namespace App\Providers;

use App\Services\Authentication\Facade\AuthenticationFacade;
use App\Services\Authentication\Facade\AuthenticationFacadeInterface;
use App\Services\Authentication\Facade\AuthenticationLoginInterface;
use App\Services\Authentication\Facade\AuthenticationRegisterInterface;
use App\Services\Authentication\Facade\Components\AuthenticationLogin;
use App\Services\Authentication\Facade\Components\AuthenticationRegister;
use App\Services\CoursesHierarchy\CoursesHierarchyAdmin;
use App\Services\CoursesHierarchy\CoursesHierarchyAdminInterface;
use App\Services\ItemsStatusFlag\ItemsStatusFlag;
use App\Services\ItemsStatusFlag\ItemsStatusFlagInterface;
use App\Services\LessonSectionStatus\LessonSectionStatus;
use App\Services\LessonSectionStatus\LessonSectionStatusInterface;
use App\Services\Mailer\Mailer;
use App\Services\Mailer\MailerInterface;
use App\Services\Menu\MenuAdmin;
use App\Services\Menu\MenuAdminInterface;
use App\Services\Menu\MenuUserContactMessages;
use App\Services\Menu\MenuUserContactMessagesInterface;
use App\Services\NumericHelper\NumericHelper;
use App\Services\NumericHelper\NumericHelperInterface;
use App\Services\Progress\ChapterProgressInterface;
use App\Services\Progress\Decorator\Decorators\ChapterProgress;
use App\Services\Progress\Decorator\Decorators\CourseProgress;
use App\Services\Progress\Decorator\Decorators\LessonProgress;
use App\Services\Progress\Decorator\LessonSectionProgress;
use App\Services\Progress\CourseProgressInterface;
use App\Services\Progress\LessonProgressInterface;
use App\Services\Progress\LessonSectionProgressInterface;
use App\Services\Progress\Wrapper\ProgressWrapper;
use App\Services\Progress\Wrapper\ProgressWrapperInterface;
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
        app()->singleton(LessonSectionStatusInterface::class, LessonSectionStatus::class);
        app()->singleton(AuthenticationFacadeInterface::class, AuthenticationFacade::class);
        app()->singleton(AuthenticationRegisterInterface::class, AuthenticationRegister::class);
        app()->singleton(AuthenticationLoginInterface::class, AuthenticationLogin::class);
        app()->singleton(MailerInterface::class, Mailer::class);

        //Progress - Decorator Design Pattern
        app()->singleton(LessonSectionProgressInterface::class, LessonSectionProgress::class);
        app()->singleton(LessonProgressInterface::class, LessonProgress::class);
        app()->singleton(ChapterProgressInterface::class, ChapterProgress::class);
        app()->singleton(CourseProgressInterface::class, CourseProgress::class);
        app()->bind(ProgressWrapperInterface::class, ProgressWrapper::class);
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
