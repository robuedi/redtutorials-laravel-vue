<?php


namespace App\Services\Progress\Decorator\Decorators;

use App\Repositories\ChapterRepositoryInterface;
use App\Services\Progress\ChapterProgressInterface;
use App\Services\Progress\CourseProgressInterface;
use App\Services\Progress\Decorator\ProgressDecorator;
use App\Services\Progress\Decorator\Wrapper\ProgressWrapperInterface;

class CourseProgress extends ProgressDecorator implements CourseProgressInterface
{
    private ChapterRepositoryInterface $section_repository;

    public function __construct(ChapterProgressInterface $sub_section, ProgressWrapperInterface $progress_wrapper, ChapterRepositoryInterface $section_repository)
    {
        parent::__construct($sub_section, $progress_wrapper);
        $this->section_repository = $section_repository;
    }

    public function getChildrenByParent()
    {
        return $this->section_repository->getPublicChaptersByCourses($this->ids, ['id', 'course_id'])->groupBy('course_id')->toArray();
    }
}
