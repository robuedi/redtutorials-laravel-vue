<?php


namespace App\Repositories;

use App\Models\LessonSection;
use Illuminate\Support\Facades\DB;

class LessonSectionRepository implements LessonSectionRepositoryInterface
{
    public function countPublicQuizByLessons(array $lessons_id)
    {

        return LessonSection::whereIn('lesson_id', $lessons_id)
            ->public(true)
            ->where('type', 'quiz')
            ->select('lesson_id', DB::raw('count(*) as total'))
            ->groupBy('lesson_id')
            ->pluck('total', 'lesson_id');
    }

    public function getQuizByLessons(array $lessons_id = [], array $select = [])
    {

        return LessonSection::whereIn('lesson_id', $lessons_id)
            ->public(true)
            ->where('type', 'quiz')
            ->select($select)
            ->get();
    }

    public function getLastCompletedSectionByUserLesson(?int $user_id, ?array $ids, array $select = [])
    {
        if($user_id||$ids)
        {
            return collect([]);
        }

        return LessonSection::whereIn('id', $ids)
            ->whereHas('users', function($query) use (&$user_id){
                $query->where('user.id', $user_id);
            })
            ->where('user_id', $this->getUserID())
            ->orderBy('order_weight', 'desc')
            ->select($select)
            ->first();
    }
}
