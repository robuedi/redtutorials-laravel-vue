<?php


namespace App\Repositories\Repositories;

use App\Models\Lesson;
use App\Repositories\LessonRepositoryInterface;
use Illuminate\Support\Facades\Cache;

class LessonRepository implements LessonRepositoryInterface
{
    private Lesson $lesson;

    public function __construct(Lesson $lesson)
    {
        $this->lesson = $lesson;
    }

    public function getCountTotal()
    {
        return $this->lesson->selectRaw('COUNT(id) as total')
            ->pluck('total')
            ->first();
    }

    public function getCountPublic()
    {
        return $this->lesson->selectRaw('COUNT(id) as public')
            ->public(true)
            ->pluck('public')
            ->first();
    }

    public function getCountDraft()
    {
        return $this->lesson->selectRaw('COUNT(id) as draft')
            ->draft(true)
            ->pluck('draft')
            ->first();
    }

    public function getByWeightGrouped()
    {
        return $this->lesson->whereNotNull('chapter_id')
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

        return Cache::remember(__CLASS__.__METHOD__.implode('', $chapters_ids).implode('', $select_fields),3600, function() use ($chapters_ids, $select_fields) {
            return $this->lesson->whereIn('chapter_id', $chapters_ids)
                ->withSlug(true)
                ->weightOrdering()
                ->select($select_fields)
                ->public(true)
                ->get();
        });
    }

    public function getLessonByCourseChapterLessonSlugs(string $course_slug, string $chapter_slug, string $lesson_slug, array $select = [], array $with = [])
    {
        return Cache::remember(__CLASS__.__METHOD__.$course_slug.$chapter_slug.$lesson_slug.implode('', $select).implode('', $with),3600, function() use ($course_slug, $chapter_slug, $lesson_slug, $select, $with) {
            $query = $this->lesson->wherehas('chapter', function($query) use (&$chapter_slug){
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
        });

    }
}
