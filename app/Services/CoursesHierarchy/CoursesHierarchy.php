<?php

namespace App\Services\CoursesHierarchy;

use App\Course;
use App\Lesson;
use App\Repositories\ChapterRepositoryInterface;
use App\Repositories\CourseRepositoryInterface;
use App\Repositories\LessonRepositoryInterface;
use URL;


class CoursesHierarchy implements ICoursesHierarchy
{
    private $courses;
    private $chapters;
    private $lessons;
    private $hierarchical_list = [];
    private $list_format;

    //will be highlighted
    protected $pointing_id = null;

    public function __construct(ChapterRepositoryInterface $chapter_repository, CourseRepositoryInterface $course_repository)
    {
        $this->courses  = $course_repository->getByWeight();
        $this->chapters = $chapter_repository->getByWeightGroupedByCourse();
    }

    public function setPointingID(string $pointing_id){
        $this->pointing_id = $pointing_id;
    }

    public function setLessons($lessons){
        $this->lessons = $lessons;
    }

    public function setChapters($chapters){
        $this->chapters = $chapters;
    }

    public function setCourses($courses){
        $this->courses = $courses;
    }

    public function getLessons(){
        return $this->lessons;
    }

    public function getChapters(){
        return $this->chapters;
    }

    public function getCourses(){
        return $this->courses;
    }

    private function makeHierarchyList()
    {
        //loop courses
        foreach($this->courses as $key => $course)
        {
            $parent_level = '';
            //check course children (go into recursive function)
            $children = $this->getChapterChildren( $course, $parent_level);

            //add new course and it's children
            $this->hierarchical_list[] = $this->setCourseData($key, $course, $children);
        }
    }

    public function getHierarchyList()
    {
        $this->makeHierarchyList();

        switch ($this->list_format)
        {
            case 'json':
                return json_encode($this->hierarchical_list);
            default:
                return $this->hierarchical_list;
        }
    }

    public function setJsonFormat()
    {
        $this->list_format = 'json';
        return $this;
    }

    private function getChapterChildren(&$parent, &$parent_level)
    {
        $children = [];
        //check if parent has chapter children
        if(isset($this->chapters[$parent->id]))
        {
            //loop chapter children
            foreach ($this->chapters[$parent->id] as $key => $child)
            {
                $child_level = $key+1;
                $inherit_level = $parent_level.$child_level.'. ';
                $child->parent = $parent;

                //check if has also has children
                $grandchildren = $this->getChapterChildren($child, $inherit_level);

                $child->inherit_level = $inherit_level;

                //save chapters data and it's children
                $children[] = $this->setChapterData($child, $grandchildren);
            }
        }

        //check if parent has lesson children
        if(isset($this->lessons[$parent->id]))
        {
            //loop lesson children
            foreach ($this->lessons[$parent->id] as $key => $child)
            {
                //save lesson data
                $child->parent = $parent;
                $children[] = $this->setLessonData($child);
            }
        }

        return $children;
    }

    protected function setCourseData(&$key, &$course, &$children)
    {
        $data = [
            'index'     => $key,
            'name'      => $course->name,
            'children'  => $children
        ];

        return $data;
    }

    protected function setChapterData(&$chapter, &$children)
    {
        $data = [
            'name'      => $chapter->name,
            'children'  => $children
        ];

        return $data;
    }

    protected function setLessonData(&$lesson)
    {
        $data = [
            'name'      => $lesson,
        ];

        return $data;
    }

}
