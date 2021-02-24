<?php


namespace App\Services\UserProgress;

use App\Repositories\ChapterRepositoryInterface;
use Illuminate\Support\Collection;

class CourseStatus extends AbstractSectionsStatus implements CourseStatusInterface
{
    private ChapterStatusInterface $chapter_status;
    private ChapterRepositoryInterface $chapter_repository;
    private array $children_status;
    private ?Collection $children_grouped;
    private ?Collection $children;

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
        if(!isset($this->children_status))
        {
            //get chapter's lessons
            $this->getChildren();
            $this->makeChildrenStatus();
        }

        return $this->chapter_status;
    }

    protected function makeStatus()
    {
        if(!$this->getUserID() || !$this->getIDs())
        {
            return;
        }

        //get courses' chapters
        $this->getChildren();

        //group lessons by chapter
        $this->makeChildrenGroups();

        //get chapter's lesson status
        $this->makeChildrenStatus();


        // calculate the status by chapter
        foreach ($this->children_grouped as $course_id => $chapters_id)
        {
            $course_lessons = array_intersect_key($this->children_status, array_flip($chapters_id));
            $this->response[$course_id] = count($course_lessons) ? array_sum($course_lessons)/count($course_lessons) : 0;
        }
    }

    private function getChildren()
    {
        //get chapter's lessons
        $this->children = $this->chapter_repository->getPublicChaptersByCourses($this->ids, ['id', 'course_id']);
    }

    protected function makeChildrenGroups()
    {
        //group chapters by course
        $this->children_grouped = $this->children->groupBy('course_id')->map(function ($item){
            return $item->pluck('id')->toArray();
        });
    }

    protected function makeChildrenStatus()
    {
        //get courses' chapters status
        $this->children_status = $this->chapter_status
            ->setUserID($this->getUserID())
            ->setIDs($this->children->pluck('id')->toArray())
            ->getStatus();
    }
}
