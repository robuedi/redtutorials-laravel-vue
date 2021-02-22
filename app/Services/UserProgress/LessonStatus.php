<?php

namespace App\Services\UserProgress;

use App\Repositories\LessonSectionRepositoryInterface;
use App\Repositories\LessonSectionUserRepositoryInterface;

class LessonStatus implements LessonStatusInterface
{
    private $user_id;
    private $lessons_id;
    private $floor_rounded = true;
    private $response = [];
    private LessonSectionUserRepositoryInterface $lesson_section_user_repository;
    private LessonSectionRepositoryInterface $lesson_section_repository;

    public function __construct(LessonSectionUserRepositoryInterface $lesson_section_user_repository, LessonSectionRepositoryInterface $lesson_section_repository )
    {
        $this->lesson_section_user_repository = $lesson_section_user_repository;
        $this->lesson_section_repository = $lesson_section_repository;

    }

    public function setUserID(int $user_id)
    {
        $this->user_id = $user_id;
        return $this;
    }

    public function setLessonsIDs(array $lessons_id = [])
    {
        $this->lessons_id = $lessons_id;
        return $this;
    }

    public function setFloorRounded(bool $floor_rounded)
    {
        $this->floor_rounded = $floor_rounded;
        return $this;
    }

    private function makeStatus()
    {
        if(!$this->user_id || !$this->lessons_id)
        {
            return $this;
        }

        //get all the sections completed be user for the lesson
        $user_sections = $this->lesson_section_user_repository->countLessonSectionUserByLessons($this->user_id, $this->lessons_id, 1, 'quiz');

        //get all the sections from the lessons
        $all_sections = $this->lesson_section_repository->countByLessons($this->lessons_id, 1, 'quiz');

        //get the percentage
        foreach ($this->lessons_id as $index => $lesson_id)
        {
            if(!isset($user_sections[$lesson_id]) || !isset($all_sections[$lesson_id]))
            {
                $this->response[$lesson_id] = 0;
                continue;
            }

            $this->response[$lesson_id] = ($user_sections[$lesson_id]*100)/$all_sections[$lesson_id];
        }

        //round values?
        if($this->floor_rounded)
        {
            array_walk($this->response, function (&$value) {
                $value = (int)$value;
            });
        }
    }

    public function getStatus()
    {
        $this->makeStatus();

        return $this->response;
    }
}
