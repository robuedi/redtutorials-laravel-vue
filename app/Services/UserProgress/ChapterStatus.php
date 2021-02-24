<?php


namespace App\Services\UserProgress;

use App\Repositories\LessonRepositoryInterface;

class ChapterStatus extends AbstractSectionsStatus implements ChapterStatusInterface
{
    use CourseChapterStatus;

    private LessonRepositoryInterface $lesson_repository;
    private LessonStatusInterface $lesson_status;

    public function __construct(LessonRepositoryInterface $lesson_repository, LessonStatusInterface $lesson_status)
    {
        $this->lesson_repository = $lesson_repository;
        $this->lesson_status = $lesson_status;
    }

    public function setLessonsStatus(LessonStatusInterface $lesson_status) : ChapterStatusInterface
    {
        $this->lesson_status = $lesson_status;
        return $this;
    }

    public function getLessonsStatus() : LessonStatusInterface
    {
        return $this->lesson_status;
    }

    protected function makeStatus()
    {
        if(!$this->getUserID() || !$this->getIDs())
        {
            return;
        }

        //get chapter's lessons
        $children = $this->lesson_repository->getPublicLessonsByChapters($this->getIDs(), ['id', 'chapter_id']);

        //group lessons by chapter
        $children_grouped = $children->groupBy('chapter_id')->map(function ($item){
            return $item->pluck('id')->toArray();
        });

        //get chapter's lesson status
        $children_status = $this->lesson_status
            ->setUserID($this->getUserID())
            ->setIDs($children->pluck('id')->toArray())
            ->getStatus();

        $this->response = $this->getResult($children_grouped, $children_status);
    }
}
