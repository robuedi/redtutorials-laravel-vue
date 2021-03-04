<?php


namespace App\Services\LessonSectionStatus;


use App\Services\Progress\Wrapper\ProgressWrapperInterface;

class LessonSectionStatus implements LessonSectionStatusInterface
{
    private static ?int $status = null;
    private static ?array $current_user_progress = null;
    private static ?int $currently_active;

    public function resetStatus()
    {
        self::$status = null;
    }

    public function checkStatus(ProgressWrapperInterface $progress, int $id, string $type) : int
    {
        // already completed
        if($progress->checkFullyCompleted())
        {
            if(self::$status === null)
            {
                self::$status = 1;
                self::$currently_active = $id;
                return self::$status;
            }

            self::$status = 2;
            return self::$status;
        }

        //none started
        if($progress->checkNoneStarted())
        {
            if(self::$status === null)
            {
                self::$status = 1;
                self::$currently_active = $id;
                return self::$status;
            }

            if (self::$status === 1 && $type === 'quiz')
            {

                self::$status = 2;
                return self::$status;
            }

            self::$status = 0;
            return self::$status;
        }

        //completed until
        if(self::$current_user_progress === null)
        {
            self::$current_user_progress = $progress->getCurrentUserProgress();
        }

        if(array_sum(self::$current_user_progress))
        {
            self::$status = 2;

            if($type === 'quiz')
            {
                unset(self::$current_user_progress[$id]);
            }

            return self::$status;
        }

        if(!empty(self::$current_user_progress)&& $type === 'text')
        {
            self::$status = 1;
            self::$currently_active = $id;
            return self::$status;
        }

        if($type === 'quiz' && self::$status === 1)
        {
            self::$status = 2;
            self::$current_user_progress = [];
            return self::$status;
        }

        self::$status = 0;
        return self::$status;
    }

    public function checkCurrentlyActive(int $id) : bool
    {
        if(self::$currently_active === $id)
        {
            return true;
        }

        return false;
    }
}
