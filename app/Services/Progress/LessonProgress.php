<?php


namespace App\Services\Progress;


use App\Repositories\LessonSectionRepositoryInterface;

class LessonProgress extends ProgressDecorator
{
    private LessonSectionRepositoryInterface $lesson_section_repository;

    public function __construct(Progress $sub_section, LessonSectionRepositoryInterface $lesson_section_repository)
    {
        parent::__construct($sub_section);
        $this->lesson_section_repository = $lesson_section_repository;
    }

    public function getProgress(): array
    {
        $subsection_status = parent::getProgress();
        $subsection_ids = $this->sub_section->getIDs();

        return array_map(function ($id) use (&$subsection_status, &$subsection_ids){
            if(!isset($subsection_status[$id], $subsection_ids[$id]))
            {
                return 0;
            }

            return ($subsection_status[$id]*100)/$subsection_ids[$id];
        }, $this->ids);
    }

    public function setIDs(array $ids): Progress
    {
        $this->ids = $ids;
        parent::setIDs($this->lesson_section_repository->countPublicQuizByLessons($ids));
    }

}
