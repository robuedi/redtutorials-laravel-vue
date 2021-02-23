<?php


namespace App\Repositories;

use App\Models\LessonSection;
use App\Models\LessonSectionUser;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LessonSectionUserRepository implements LessonSectionUserRepositoryInterface
{
    public function countLessonSectionUserByLessons(int $user_id, array $lessons_id, int $is_public, string $type)
    {
        return LessonSection::whereHas('users', function($query) use (&$user_id){
                $query->where('users.id', $user_id);
            })
            ->where('is_public', $is_public)
            ->where('type', $type)
            ->whereIn('lesson_id', $lessons_id)
            ->select('lesson_id', DB::raw('count(*) as total'))
            ->groupBy('lesson_id')
            ->pluck('total', 'lesson_id');
    }
}
