<?php


namespace App\Services\UserProgress;

use App\Repositories\ChapterRepositoryInterface;

class CourseStatus extends AbstractSectionsStatus implements CourseStatusInterface
{
    private ChapterStatusInterface $chapter_status;
    private ChapterRepositoryInterface $chapter_repository;

    public function __construct(ChapterStatusInterface $chapter_status, ChapterRepositoryInterface $chapter_repository)
    {
        $this->chapter_status = $chapter_status;
        $this->chapter_repository = $chapter_repository;
    }

    public function setChaptersStatus(ChapterStatusInterface $chapter_status)
    {
        $this->chapter_status = $chapter_status;
        return $this;
    }

    protected function makeStatus()
    {
        if(!$this->getUserID() || !$this->getIDs())
        {
            return;
        }

        //get courses' chapters
        $chapters_by_course = $this->chapter_repository->getChaptersByCourses($this->ids, 1, ['id', 'course_id']);

        $all_chapters = [];
        //group lessons by chapter
        $course_chapters_grouped = $chapters_by_course->groupBy('course_id')->map(function ($item) use (&$all_chapters){
            $ids = $item->pluck('id')->toArray();
            $all_chapters = array_merge($all_chapters, $ids);
            return $ids;
        });

        //get chapter's lesson status
        $chapter_status_values = $this->chapter_status
            ->setUserID($this->user_id ?? 0)
            ->setIDs($all_chapters)
            ->getStatus();

        // calculate the status by chapter
        foreach ($course_chapters_grouped as $course_id => $chapters_id)
        {
            $course_lessons = array_intersect_key($chapter_status_values, array_flip($chapters_id));
            $this->response[$course_id] = count($course_lessons) ? array_sum($course_lessons)/count($course_lessons) : 0;
        }
    }
}
