<?php

namespace App\Services\Progress\CourseComponents;

use App\Repositories\LessonSectionUserRepositoryInterface;
use App\Services\Progress\Decorator\Progress;
use App\Services\Progress\LessonSectionProgressInterface;
use App\Services\Progress\Wrapper\ProgressWrapperInterface;

class LessonSectionProgress implements Progress, LessonSectionProgressInterface
{
    private array $ids = [];
    private array $users_id;

    private LessonSectionUserRepositoryInterface $lesson_section_user_repository;
    private ProgressWrapperInterface $wrapper;

    public function __construct(LessonSectionUserRepositoryInterface $lesson_section_user_repository, ProgressWrapperInterface $wrapper)
    {
        $this->lesson_section_user_repository = $lesson_section_user_repository;
        $this->wrapper = $wrapper;
    }

    public function setIDs(array $ids): Progress
    {
        $this->ids = $ids;
        return $this;
    }

    public function setUsersIDs(array $users_id): Progress
    {
        $this->users_id = $users_id;
        return $this;
    }

    public function getUsersIDs(): array
    {
        return $this->users_id;
    }

    public function getIDs() : array
    {
        return $this->ids;
    }

    public function getProgress(bool $floor = false): ProgressWrapperInterface
    {
        //get last completed
        $completed_sections = $this->lesson_section_user_repository->getCompletedSections($this->users_id, $this->ids)->groupBy('user_id')->toArray();

        //transform array
        array_walk($completed_sections, function (&$sections){
            array_walk($sections, function (&$section){
                $section = $section['lesson_section_id'];
            });
        });

        //check if id in array
        $response = [];
        array_walk($this->users_id, function ($user_id) use (&$response, &$completed_sections){
            //go through sections
            array_walk($this->ids, function ($section_id) use (&$response, &$completed_sections, &$user_id){
                //check if section in user's group
                $response[$user_id][$section_id] = (int)(isset($completed_sections[$user_id]) ? in_array($section_id, $completed_sections[$user_id], false) : false);
            }, $this->ids);
        });

        return $this->wrapper->setProgress($response);
    }
}
