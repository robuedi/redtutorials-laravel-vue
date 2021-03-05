<?php


namespace App\Repositories\Repositories;

use App\Models\Chapter;
use App\Repositories\ChapterRepositoryInterface;

class ChapterRepository implements ChapterRepositoryInterface
{
    private Chapter $chapter;

    public function __construct(Chapter $chapter)
    {
        $this->chapter = $chapter;
    }

    public function getCountTotal()
    {
        return $this->chapter->selectRaw('COUNT(id) as total')
            ->pluck('total')
            ->first();
    }

    public function getCountPublic()
    {
        return $this->chapter->selectRaw('COUNT(id) as public')
            ->public(true)
            ->pluck('public')
            ->first();
    }

    public function getCountDraft()
    {
        return $this->chapter->selectRaw('COUNT(id) as draft')
            ->draft(true)
            ->pluck('draft')
            ->first();
    }

    public function getByWeightGroupedByCourse()
    {
        return $this->chapter->weightOrdering()
            ->select('id', 'name', 'course_id', 'is_draft', 'is_public')
            ->get()
            ->groupBy('course_id');
    }

    public function getPublicChaptersByCourses(array $courses_ids, array $select_fields = [])
    {
        return $this->chapter->whereIn('course_id', $courses_ids)
            ->withSlug(true)
            ->weightOrdering()
            ->select($select_fields)
            ->public(true)
            ->get();
    }
}
