<?php


namespace App\Services\Progress\Course;

use App\Repositories\ChapterRepositoryInterface;
use App\Services\Progress\Progress;
use App\Services\Progress\ProgressDecorator;

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
