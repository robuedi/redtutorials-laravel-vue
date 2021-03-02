<?php


namespace App\Services\Progress;

use App\Repositories\LessonSectionRepositoryInterface;
use App\Repositories\LessonSectionUserRepository;

class LessonSectionProgress implements Progress
{
    private array $ids = [];
    private int $user_id;

    private LessonSectionUserRepository $lesson_section_user_repository;

    public function __construct(LessonSectionUserRepository $lesson_section_user_repository)
    {
        $this->lesson_section_user_repository = $lesson_section_user_repository;
    }

    public function setIDs(array $ids): Progress
    {
        $this->ids = $ids;
    }

    public function setUserID(int $user_id): Progress
    {
        $this->user_id = $user_id;
    }

    public function getIDs() : array
    {
        return $this->ids;
    }

    public function getProgress(): array
    {
        //get last completed
        $completed_sections_ids = $this->lesson_section_user_repository->getCompletedSections($this->user_id, $this->ids);

        return array_map(function ($id) use (&$completed_sections_ids){
            return in_array($id, $completed_sections_ids, false);
        }, $completed_sections_ids);
    }
}
