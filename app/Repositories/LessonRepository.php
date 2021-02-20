<?php


namespace App\Repositories;


use App\Models\Lesson;

class LessonRepository implements LessonRepositoryInterface
{
    public function getCountTotal()
    {
        return Lesson::selectRaw('COUNT(id) as total')
            ->pluck('total')
            ->first();
    }

    public function getCountPublic()
    {
        return Lesson::selectRaw('COUNT(id) as public')
            ->where('is_public', 1)
            ->pluck('public')
            ->first();
    }

    public function getCountDraft()
    {
        return Lesson::selectRaw('COUNT(id) as draft')
            ->where('is_draft', 1)
            ->pluck('draft')
            ->first();
    }

    public function getByWeightGrouped()
    {
        Lesson::whereNotNull('chapter_id')
            ->orderBy('order_weight')
            ->select('id', 'name', 'chapter_id', 'is_public', 'is_draft')
            ->get()
            ->groupBy('chapter_id');
    }

    public function getLessonsByChapters(array $chapters_ids, int $public = 1)
    {
        if(!$chapters_ids)
        {
            return collect([]);
        }

        return Lesson::whereIn('chapter_id', $chapters_ids)
            ->where('is_public', $public)
            ->whereNotNull('slug')
            ->orderBy('order_weight')
            ->select('id', 'name', 'slug')
            ->get();
    }
}
