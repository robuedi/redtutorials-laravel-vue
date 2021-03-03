<?php


namespace App\Services\Progress\CourseComponents;

use App\Repositories\ChapterRepositoryInterface;
use App\Services\Progress\CourseProgressInterface;
use App\Services\Progress\Decorator\Progress;
use App\Services\Progress\Decorator\ProgressDecorator;

class CourseProgress extends ProgressDecorator implements CourseProgressInterface
{
    private ChapterRepositoryInterface $section_repository;

    public function __construct(Progress $sub_section, ChapterRepositoryInterface $section_repository)
    {
        parent::__construct($sub_section);
        $this->section_repository = $section_repository;
    }

    public function getChildrenByParent()
    {
        return $this->section_repository->getPublicChaptersByCourses($this->ids, ['id', 'course_id'])->groupBy('course_id')->toArray();
    }
}
