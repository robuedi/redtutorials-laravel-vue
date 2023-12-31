<?php


namespace App\Services\Progress\Decorator\Decorators;

use App\Repositories\LessonRepositoryInterface;
use App\Services\Progress\ChapterProgressInterface;
use App\Services\Progress\Decorator\ProgressDecorator;
use App\Services\Progress\Decorator\Wrapper\ProgressWrapperInterface;
use App\Services\Progress\LessonProgressInterface;

class ChapterProgress extends ProgressDecorator implements ChapterProgressInterface
{
    private LessonRepositoryInterface $section_repository;

    public function __construct(LessonProgressInterface $sub_section, ProgressWrapperInterface $progress_wrapper, LessonRepositoryInterface $section_repository)
    {
        parent::__construct($sub_section, $progress_wrapper);
        $this->section_repository = $section_repository;
    }

    protected function getChildrenByParent()
    {
        return $this->section_repository->getPublicLessonsByChapters($this->ids, ['id', 'chapter_id'])->groupBy('chapter_id')->toArray();
    }
}
