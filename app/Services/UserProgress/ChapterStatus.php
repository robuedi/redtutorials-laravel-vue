<?php


namespace App\Services\UserProgress;


use App\Repositories\LessonRepositoryInterface;
use App\Services\Authentication\AuthenticationServiceInterface;

class ChapterStatus implements ChapterStatusInterface
{
    private $user_id;
    private $chapters_id;
    private $floor_rounded = true;
    private $response = [];
    private $lesson_status_values = [];
    private LessonRepositoryInterface $lesson_repository;
    private LessonStatusInterface $lesson_status;

    public function __construct(LessonRepositoryInterface $lesson_repository, LessonStatusInterface $lesson_status, AuthenticationServiceInterface $authentication_service)
    {
        $this->lesson_repository = $lesson_repository;
        $this->lesson_status = $lesson_status;
    }

    public function setUserID(?int $user_id)
    {
        $this->user_id = $user_id;
        return $this;
    }

    public function setChaptersIDs(array $chapters_id = [])
    {
        $this->chapters_id = $chapters_id;
        return $this;
    }

    public function setFloorRounded(bool $floor_rounded)
    {
        $this->floor_rounded = $floor_rounded;
        return $this;
    }


    private function makeStatus()
    {
        if(!$this->user_id || !$this->chapters_id)
        {
            return;
        }

        //get chapter's lessons
        $lessons_by_chapter = $this->lesson_repository->getLessonsByChapters($this->chapters_id, 1, ['id', 'chapter_id']);

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
                            ->setLessonsIDs($all_lessons)
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
        if(!$this->user_id || !$this->chapters_id)
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

    public function getStatus()
    {
        $this->makeStatus();

        return $this->response;
    }
}
