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
}
