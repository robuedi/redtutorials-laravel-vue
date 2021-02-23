<?php


namespace App\Repositories;

use App\Models\Chapter;
use App\Repositories\ChapterRepositoryInterface;

class ChapterRepository implements ChapterRepositoryInterface
{
    public function getCountTotal()
    {
        return Chapter::selectRaw('COUNT(id) as total')
            ->pluck('total')
            ->first();
    }

    public function getCountPublic()
    {
        return Chapter::selectRaw('COUNT(id) as public')
            ->public(true)
            ->pluck('public')
            ->first();
    }

    public function getCountDraft()
    {
        return Chapter::selectRaw('COUNT(id) as draft')
            ->draft(true)
            ->pluck('draft')
            ->first();
    }

    public function getByWeightGroupedByCourse()
    {
        return Chapter::weightOrdering()
            ->select('id', 'name', 'course_id', 'is_draft', 'is_public')
            ->get()
            ->groupBy('course_id');
    }

    public function getChaptersByCourses(array $courses_ids, bool $public = true, array $select_fields = [])
    {
        return Chapter::whereIn('course_id', $courses_ids)
            ->withSlug(true)
            ->weightOrdering()
            ->select($select_fields)
            ->public($public)
            ->get();
    }
}
