<?php


namespace App\Services\Progress;


use App\Repositories\LessonRepositoryInterface;

class ChapterProgress extends ProgressDecorator
{
    private LessonRepositoryInterface $lesson_repository;

    public function __construct(Progress $sub_section, LessonRepositoryInterface $lesson_repository)
    {
        parent::__construct($sub_section);
        $this->lesson_repository = $lesson_repository;
    }

    public function getProgress(): array
    {
        $subsection_status = parent::getProgress();
        $subsection_ids = $this->sub_section->getIDs();

        $response = [];
        // calculate the status by chapter
        foreach ($children_grouped as $parent_id => $children_id)
        {
            $parent_childrens = array_intersect_key($children_status, array_flip($children_id));
            $response[$parent_id] = count($parent_childrens) ? array_sum($parent_childrens)/count($parent_childrens) : 0;
        }

        return $response;

//        return array_map(function ($id) use (&$subsection_status, &$subsection_ids){
//            if(!isset($subsection_status[$id], $subsection_ids[$id]))
//            {
//                return 0;
//            }
//
//            return ($subsection_status[$id]*100)/$subsection_ids[$id];
//        }, $this->ids);
    }

    public function setIDs(array $ids): Progress
    {
        $this->ids = $ids;
        $this->children_ids = $ids;
        parent::setIDs($this->lesson_repository->getPublicLessonsByChapters($ids, ['id']));
    }

}
