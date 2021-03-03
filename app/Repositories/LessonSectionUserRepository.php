<?php


namespace App\Repositories;

use App\Models\LessonSection;
use App\Models\LessonSectionUser;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LessonSectionUserRepository implements LessonSectionUserRepositoryInterface
{
    public function countPublicQuizByLessons(int $user_id, array $lessons_id)
    {
        return LessonSection::whereHas('users', function($query) use (&$user_id){
                $query->where('users.id', $user_id);
            })
            ->public(true)
            ->where('type', 'quiz')
            ->whereIn('lesson_id', $lessons_id)
            ->select('lesson_id', DB::raw('count(*) as total'))
            ->groupBy('lesson_id')
            ->pluck('total', 'lesson_id');
    }

    public function getCompletedSections(array $user_id, array $section_id = [])
    {
        return LessonSectionUser::whereIn('user_id', $user_id)
            ->whereIn('lesson_section_id', $section_id)
            ->select('lesson_section_id', 'user_id')
            ->get();
    }
}
