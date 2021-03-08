<?php


namespace App\Repositories\Repositories;

use App\Models\Lesson;
use App\Models\LessonSection;
use App\Repositories\LessonSectionRepositoryInterface;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

class LessonSectionRepository implements LessonSectionRepositoryInterface
{
    private LessonSection $lesson_section;

    public function __construct(LessonSection $lesson_section)
    {
        $this->lesson_section = $lesson_section;
    }

    public function countPublicQuizByLessons(array $lessons_id)
    {

        return $this->lesson_section->whereIn('lesson_id', $lessons_id)
            ->public(true)
            ->where('type', 'quiz')
            ->select('lesson_id', DB::raw('count(*) as total'))
            ->groupBy('lesson_id')
            ->pluck('total', 'lesson_id');
    }

    public function getQuizByLessons(array $lessons_id = [], array $select = [])
    {
        return Cache::remember(__CLASS__.__METHOD__.implode('', $lessons_id).implode('', $select),3600, function() use ($lessons_id, $select) {
            return $this->lesson_section->whereIn('lesson_id', $lessons_id)
                ->public(true)
                ->where('type', 'quiz')
                ->select($select)
                ->get();
        });
    }

    public function getLastCompletedSectionByUserLesson(?int $user_id, ?array $ids, array $select = [])
    {
        if($user_id||$ids)
        {
            return collect([]);
        }

        return $this->lesson_section->whereIn('id', $ids)
            ->whereHas('users', function($query) use (&$user_id){
                $query->where('user.id', $user_id);
            })
            ->where('user_id', $this->getUserID())
            ->orderBy('order_weight', 'desc')
            ->select($select)
            ->first();
    }
}
