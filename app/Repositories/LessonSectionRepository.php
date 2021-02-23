<?php


namespace App\Repositories;

use App\Models\LessonSection;
use Illuminate\Support\Facades\DB;

class LessonSectionRepository implements LessonSectionRepositoryInterface
{
    public function countByLessons(array $lessons_id, bool $is_public, string $type)
    {

        return LessonSection::whereIn('lesson_id', $lessons_id)
            ->public($is_public)
            ->where('type', $type)
            ->select('lesson_id', DB::raw('count(*) as total'))
            ->groupBy('lesson_id')
            ->pluck('total', 'lesson_id');
    }
}
