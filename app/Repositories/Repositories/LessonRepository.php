<?php


namespace App\Repositories\Repositories;

use App\Models\Lesson;
use App\Repositories\LessonRepositoryInterface;
use Illuminate\Support\Facades\DB;

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

    public function getLessonByCourseChapterLessonSlugs(string $course_slug, string $chapter_slug, string $lesson_slug, array $select = [], array $with = [])
    {
        $query = Lesson::wherehas('chapter', function($query) use (&$chapter_slug){
                $query->where('slug', $chapter_slug);
                $query->where('is_public', 1);
            })
            ->wherehas('chapter.course', function($query) use (&$course_slug){
                $query->where('slug', $course_slug);
                $query->where('is_public', 1);
            })
            ->public(true)
            ->where('slug', '=', $lesson_slug)
            ->select($select);

        if($with)
        {
            $query->with($with);
        }

        return $query->first();
    }
}
