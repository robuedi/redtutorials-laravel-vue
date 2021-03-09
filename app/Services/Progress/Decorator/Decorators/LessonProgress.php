<?php


namespace App\Services\Progress\Decorator\Decorators;

use App\Repositories\LessonSectionRepositoryInterface;
use App\Services\Progress\Decorator\ProgressDecorator;
use App\Services\Progress\Decorator\Wrapper\ProgressWrapperInterface;
use App\Services\Progress\LessonProgressInterface;
use App\Services\Progress\LessonSectionProgressInterface;

class LessonProgress extends ProgressDecorator implements LessonProgressInterface
{
    private LessonSectionRepositoryInterface $section_repository;

    public function __construct(LessonSectionProgressInterface $sub_section, ProgressWrapperInterface $progress_wrapper, LessonSectionRepositoryInterface $section_repository)
    {
        parent::__construct($sub_section, $progress_wrapper);
        $this->section_repository = $section_repository;
    }

    public function getChildrenByParent()
    {
        return $this->section_repository->getQuizByLessons($this->ids, ['id', 'lesson_id'])->groupBy('lesson_id')->toArray();
    }
}
