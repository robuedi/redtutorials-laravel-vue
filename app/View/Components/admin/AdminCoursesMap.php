<?php

namespace App\View\Components\admin;

use App\Services\CoursesHierarchy\CoursesHierarchyAdminInterface;
use Illuminate\View\Component;

class AdminCoursesMap extends Component
{
    public $curses_hierarchy_map;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(CoursesHierarchyAdminInterface $courses_hierarchy_admin)
    {
        $this->curses_hierarchy_map = $courses_hierarchy_admin->setDefaultAdminLessons()->setJsonFormat()->getHierarchyList();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.admin.admin-courses-map');
    }
}
