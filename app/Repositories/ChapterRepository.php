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

//    public function getChaptersHavingLessonsByCourse(int $course_id, int $public = 1)
//    {
//        return Chapter::join('lessons', 'chapters.id', '=', 'lessons.chapter_id')
//            ->where('chapters.course_id', $course_id)
//            ->where('chapters.is_public', $public)
//            ->where('lessons.is_public', $public)
//            ->whereNotNull('chapters.slug')
//            ->groupBy('chapters.id')
//            ->selectRaw('chapters.id, chapters.name, chapters.slug, COUNT(lessons.id) AS lessons_number')
//            ->orderBy('chapters.order_weight')
//            ->get();
//    }


}
