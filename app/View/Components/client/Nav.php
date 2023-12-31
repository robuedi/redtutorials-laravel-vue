<?php

namespace App\View\Components\client;

use App\Repositories\CourseRepositoryInterface;
use App\Services\Authentication\AuthenticationHelperInterface;
use Illuminate\View\Component;

class Nav extends Component
{
    public $courses;
    public $user_logged;
    public $user_first_name;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(CourseRepositoryInterface $course_repository, AuthenticationHelperInterface $authentication_helper)
    {
        $this->courses = $course_repository->getPublicWithSlug(['slug', 'name']);
        $this->user_logged = $authentication_helper->getUserLogged();
        $this->user_first_name = $authentication_helper->getUserFirstName();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.client.nav');
    }
}
