<?php


namespace App\Services\Progress\CourseComponents;

use App\Repositories\LessonRepositoryInterface;
use App\Services\Progress\ChapterProgressInterface;
use App\Services\Progress\Decorator\Progress;
use App\Services\Progress\Decorator\ProgressDecorator;

class ChapterProgress extends ProgressDecorator implements ChapterProgressInterface
{
    private LessonRepositoryInterface $section_repository;

    public function __construct(Progress $sub_section, LessonRepositoryInterface $section_repository)
    {
        parent::__construct($sub_section);
        $this->section_repository = $section_repository;
    }

    protected function getChildrenByParent()
    {
        return $this->section_repository->getPublicLessonsByChapters($this->ids, ['id', 'chapter_id'])->groupBy('chapter_id')->toArray();
    }
}
