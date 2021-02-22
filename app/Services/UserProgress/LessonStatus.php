<?php


namespace App\Services\UserProgress;


use App\Models\LessonSection;
use App\Models\UserLessonSection;

class LessonStatus
{
    public static function getStatus(int $user_id, int $lessons_id, $floor_rounded = true)
    {
        if(!$user_id || !$lessons_id)
        {
            return null;
        }

        //get all the sections completed be user for the lesson
        $user_sections = LessonSection::whereHas(array('users'=>function($query, &$user_id){
                $query->where('id', $user_id);
            }))
            ->where('is_public',1)
            ->where('type','quiz')
            ->whereIn('lesson_id', $lessons_id)
            ->get()
            ->count();


        //get all the sections from the lesson
        $all_sections = LessonSection::whereIn('lessons_sections.lesson_id', $lessons_id)
            ->where('is_public',1)
            ->where('type','quiz')
            ->get()
            ->count();

        if($all_sections == 0 || $user_sections == 0)
        {
            $completion_percentage = 0;
        }
        else
        {
            $completion_percentage = ($user_sections*100)/$all_sections;
        }

        //get percentage
        if($floor_rounded)
        {
            $completion_percentage = (int)$completion_percentage;
        }

        return $completion_percentage;

    }

    public static function addStatusToLessons($lessons)
    {
        $user = Sentinel::getUser();

        if(!$user)
        {
            foreach ($lessons as $lesson)
            {
                $lesson->completion_status = null;
            }

            return $lessons;
        }

        foreach ($lessons as $lesson)
        {
            $lesson->completion_status = self::getStatus($user->id, $lesson->id);
        }

        return $lessons;
    }
}
