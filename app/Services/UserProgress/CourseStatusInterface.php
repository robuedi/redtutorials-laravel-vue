<?php

namespace App\Services\UserProgress;

interface CourseStatusInterface
{
    public function getCourseStatus(int $course_id, int $user_id, bool $floor_rounded = true);

    public function getCoursesStatus();

    public function getAllCoursesWithUserStatus();
}
