<?php


namespace App\Services\Progress\Lesson;


use App\Repositories\LessonSectionRepositoryInterface;
use App\Services\Progress\LessonProgressInterface;
use App\Services\Progress\Progress;
use App\Services\Progress\ProgressDecorator;

class LessonProgress extends ProgressDecorator implements LessonProgressInterface
{
    private LessonSectionRepositoryInterface $section_repository;

    public function __construct(Progress $sub_section, LessonSectionRepositoryInterface $section_repository)
    {
        parent::__construct($sub_section);
        $this->section_repository = $section_repository;
    }

    public function getChildrenByParent()
    {
        return $this->section_repository->getQuizByLessons($this->ids, ['id', 'lesson_id'])->groupBy('lesson_id')->toArray();
    }
}
