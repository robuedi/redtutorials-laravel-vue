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
            ->public(true)
            ->pluck('public')
            ->first();
    }

    public function getCountDraft()
    {
        return Lesson::selectRaw('COUNT(id) as draft')
            ->draft(true)
            ->pluck('draft')
            ->first();
    }

    public function getByWeightGrouped()
    {
        Lesson::whereNotNull('chapter_id')
            ->weightOrdering()
            ->select('id', 'name', 'chapter_id', 'is_public', 'is_draft')
            ->get()
            ->groupBy('chapter_id');
    }

    public function getPublicLessonsByChapters(array $chapters_ids, array $select_fields = [])
    {
        if(!$chapters_ids)
        {
            return collect([]);
        }

        return Lesson::whereIn('chapter_id', $chapters_ids)
            ->withSlug(true)
            ->weightOrdering()
            ->select($select_fields)
            ->public(true)
            ->get();
    }
}
