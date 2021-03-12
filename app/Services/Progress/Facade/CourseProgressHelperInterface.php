<?php

namespace App\Services\Progress\Facade;

use Illuminate\Database\Eloquent\Collection;

interface CourseProgressHelperInterface
{
    public function appendStatusToCourses(Collection $courses);
}
