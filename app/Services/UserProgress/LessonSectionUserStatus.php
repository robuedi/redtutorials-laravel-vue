<?php


namespace App\Services\UserProgress;

use App\Repositories\LessonSectionRepositoryInterface;

class LessonSectionUserStatus extends AbstractSectionsStatus implements LessonSectionUserStatusInterface
{
    protected LessonSectionRepositoryInterface $lesson_section_repository;

    public function __construct(LessonSectionRepositoryInterface $lesson_section_repository)
    {
        $this->lesson_section_repository = $lesson_section_repository;
    }

    public function makeStatus()
    {
        //get last completed
        $last_completed_section = $this->lesson_section_repository->getLastCompletedSectionByUserLesson($this->getUserID(), $this->getIDs(), ['id']);

        //check if we have a completed one
        if(!$last_completed_section)
        {
            foreach ($this->getIDs() as $index => $id)
            {
                $this->response[$id] = ($index === 0) ? 1 : 0;
            }
        }
        else
        {
            $completed_checked = false;
            $make_active = false;
            foreach ($this->getIDs() as $index => $id)
            {
                //check if completed
                if($last_completed_section === $id)
                {
                    //make the next text section active because we passed already this quiz
                    $this->response[$id] = 2;
                    $completed_checked = true;
                    $make_active = true;
                }
                else if($make_active)
                {
                    $this->response[$id] = 1;
                    $make_active = false;
                }
                //check if before the one completed
                else if(!$completed_checked)
                {
                    $this->response[$id] = 2;
                }
                else
                {
                    $this->response[$id] = 0;

                }
            }

            //if all completed make the first active
            $ids = $this->getIDs();
            if($this->response[end($ids)] == 2)
            {
                $this->response[reset($ids)] = 1;
            }
        }
    }
}
