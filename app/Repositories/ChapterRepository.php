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
            ->where('is_public', 1)
            ->pluck('public')
            ->first();
    }

    public function getCountDraft()
    {
        return Chapter::selectRaw('COUNT(id) as draft')
            ->where('is_draft', 1)
            ->pluck('draft')
            ->first();
    }

    public function getByWeightGroupedByCourse()
    {
        return Chapter::orderBy('order_weight')
            ->select('id', 'name', 'course_id', 'is_draft', 'is_public')
            ->get()
            ->groupBy('course_id');
    }
}
