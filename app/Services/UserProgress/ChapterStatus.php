<?php


namespace App\Services\UserProgress;

use App\Repositories\LessonRepositoryInterface;
use Illuminate\Support\Collection;

class ChapterStatus extends AbstractSectionsStatus implements ChapterStatusInterface
{
    private LessonRepositoryInterface $lesson_repository;
    private LessonStatusInterface $lesson_status;
    private array $children_status;
    private ?Collection $children_grouped;
    private ?Collection $children;

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
        if(!isset($this->children_status))
        {
            //get chapter's lessons
            $this->getChildren();
            $this->makeChildrenStatus();
        }

        return $this->lesson_status;
    }

    protected function makeStatus()
    {
        if(!$this->getUserID() || !$this->getIDs())
        {
            return;
        }

        //get chapter's lessons
        $this->getChildren();

        //group lessons by chapter
        $this->makeChildrenGroups();

        //get chapter's lesson status
        $this->makeChildrenStatus();

        // calculate the status by chapter
        foreach ($this->children_grouped as $chapter_id => $lessons_id)
        {
            $chapters_lessons = array_intersect_key($this->children_status, array_flip($lessons_id));
            $this->response[$chapter_id] = count($chapters_lessons) ? array_sum($chapters_lessons)/count($chapters_lessons) : 0;
        }
    }

    private function getChildren()
    {
        //get chapter's lessons
        $this->children = $this->lesson_repository->getPublicLessonsByChapters($this->getIDs(), ['id', 'chapter_id']);
    }

    protected function makeChildrenGroups()
    {
        //group lessons by chapter
        $this->children_grouped = $this->children->groupBy('chapter_id')->map(function ($item){
            return $item->pluck('id')->toArray();
        });
    }

    protected function makeChildrenStatus()
    {
        //get chapter's lesson status
        $this->children_status = $this->lesson_status
            ->setUserID($this->getUserID())
            ->setIDs($this->children->pluck('id')->toArray())
            ->getStatus();
    }
}
