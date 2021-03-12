<?php


namespace App\Http\Controllers\api\v1;

use App\Http\Resources\v1\CoursesResource;
use App\Repositories\CourseRepositoryInterface;
use App\Services\Progress\Facade\CourseProgressHelperInterface;
use Illuminate\Http\Request;

class CoursesController
{
    private CourseRepositoryInterface $course_repository;
    private CourseProgressHelperInterface $course_progress_helper;

    public function __construct(CourseRepositoryInterface $course_repository, CourseProgressHelperInterface $course_progress_helper)
    {
        $this->course_repository = $course_repository;
        $this->course_progress_helper = $course_progress_helper;
    }
    public function index(Request $request)
    {
        //get courses
        $courses = $this->course_repository->getPublic([...explode(',', $request->get('fields')) ?? 'id']);

        if($request->has('extra')&&in_array('progress', explode(',',$request->get('extra'))))
        {
            $courses = $this->course_progress_helper->appendStatusToCourses($courses);
        }

        return CoursesResource::collection($courses);
    }
}
