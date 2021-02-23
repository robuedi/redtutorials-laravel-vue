<?php


namespace App\Services\UserProgress;

use App\Repositories\LessonRepositoryInterface;

class ChapterStatus extends AbstractSectionsStatus implements ChapterStatusInterface
{
    private $lesson_status_values = [];
    private LessonRepositoryInterface $lesson_repository;
    private LessonStatusInterface $lesson_status;

    public function __construct(LessonRepositoryInterface $lesson_repository, LessonStatusInterface $lesson_status)
    {
        $this->lesson_repository = $lesson_repository;
        $this->lesson_status = $lesson_status;
    }

    protected function makeStatus()
    {
        if(!$this->user_id || !$this->ids)
        {
            return;
        }

        //get chapter's lessons
        $lessons_by_chapter = $this->lesson_repository->getLessonsByChapters($this->ids, 1, ['id', 'chapter_id']);

        $all_lessons = [];
        //group lessons by chapter
        $lessons_chapter_grouped = $lessons_by_chapter->groupBy('chapter_id')->map(function ($item) use (&$all_lessons){
            $ids = $item->pluck('id')->toArray();
            $all_lessons = array_merge($all_lessons, $ids);
            return $ids;
        });

        //get chapter's lesson status
        $this->lesson_status_values = $this->lesson_status
                            ->setUserID($this->user_id ?? 0)
                            ->setIDs($all_lessons)
                            ->getStatus();

        // calculate the status by chapter
        foreach ($lessons_chapter_grouped as $chapter_id => $lessons_id)
        {
            $chapters_lessons = array_intersect_key($this->lesson_status_values, array_flip($lessons_id));
            $this->response[$chapter_id] = count($chapters_lessons) ? array_sum($chapters_lessons)/count($chapters_lessons) : 0;
        }

        //if rounded
        if($this->floor_rounded)
        {
            foreach ($this->response as $key => $value)
            {
                $this->response[$key] = (int)$this->response[$key];
            }
        }
    }

    public function getLessonsStatus()
    {
        if(!$this->user_id || !$this->ids)
        {
            return [];
        }

        if(!isset($this->lesson_status_values) )
        {
            $this->makeStatus();
        }

        //if rounded
        if($this->floor_rounded)
        {
            foreach ($this->lesson_status_values ?? [] as $key => $value)
            {
                $this->lesson_status_values[$key] = (int)$this->lesson_status_values[$key];
            }
        }

        return $this->lesson_status_values;
    }

}
