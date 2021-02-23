<?php

namespace App\Services\UserProgress;

use App\Repositories\LessonSectionRepositoryInterface;
use App\Repositories\LessonSectionUserRepositoryInterface;

class LessonStatus extends AbstractSectionsStatus implements LessonStatusInterface
{
    private LessonSectionUserRepositoryInterface $lesson_section_user_repository;
    private LessonSectionRepositoryInterface $lesson_section_repository;

    public function __construct(LessonSectionUserRepositoryInterface $lesson_section_user_repository, LessonSectionRepositoryInterface $lesson_section_repository )
    {
        $this->lesson_section_user_repository = $lesson_section_user_repository;
        $this->lesson_section_repository = $lesson_section_repository;
    }

    protected function makeStatus()
    {
        if(!$this->getUserID() || !$this->getIDs())
        {
            return;
        }

        //get all the sections completed be user for the lesson
        $user_sections = $this->lesson_section_user_repository->countLessonSectionUserByLessons($this->user_id, $this->ids, 1, 'quiz');

        //get all the sections from the lessons
        $all_sections = $this->lesson_section_repository->countByLessons($this->ids, true, 'quiz');

        //get the percentage
        foreach ($this->ids as $index => $lesson_id)
        {
            if(!isset($user_sections[$lesson_id], $all_sections[$lesson_id]))
            {
                $this->response[$lesson_id] = 0;
                continue;
            }

            $this->response[$lesson_id] = ($user_sections[$lesson_id]*100)/$all_sections[$lesson_id];
        }
    }
}
