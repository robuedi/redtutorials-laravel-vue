<?php


namespace App\Services\UserProgress;

use App\Repositories\ChapterRepositoryInterface;

class CourseStatus extends AbstractSectionsStatus implements CourseStatusInterface
{
    use CourseChapterStatus;

    private ChapterStatusInterface $chapter_status;
    private ChapterRepositoryInterface $chapter_repository;

    public function __construct(ChapterStatusInterface $chapter_status, ChapterRepositoryInterface $chapter_repository)
    {
        $this->chapter_status = $chapter_status;
        $this->chapter_repository = $chapter_repository;
    }

    public function setChaptersStatus(ChapterStatusInterface $chapter_status) : CourseStatusInterface
    {
        $this->chapter_status = $chapter_status;
        return $this;
    }

    public function getChaptersStatus() : ChapterStatusInterface
    {
        return $this->chapter_status;
    }

    protected function makeStatus()
    {
        if(!$this->getUserID() || !$this->getIDs())
        {
            return;
        }

        //get chapter's lessons
        $children = $this->chapter_repository->getPublicChaptersByCourses($this->ids, ['id', 'course_id']);

        //group chapters by course
        $children_grouped = $children->groupBy('course_id')->map(function ($item){
            return $item->pluck('id')->toArray();
        });

        //get courses' chapters status
        $children_status = $this->chapter_status
            ->setUserID($this->getUserID())
            ->setIDs($children->pluck('id')->toArray())
            ->getStatus();

        $this->response = $this->getResult($children_grouped, $children_status);
    }
}
