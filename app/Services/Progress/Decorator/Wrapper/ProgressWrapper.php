<?php


namespace App\Services\Progress\Decorator\Wrapper;


class ProgressWrapper implements ProgressWrapperInterface
{
    private array $progress;
    private array $current_user_progress = [];
    private int $percentage = 1;

    public function setProgress(array $progress) : ProgressWrapperInterface
    {
        $this->progress = $progress;
        return $this;
    }

    public function setPercentage(bool $percentage) : ProgressWrapperInterface
    {
        if($percentage)
        {
            $this->percentage = 100;
        }

        return $this;
    }

    public function getRaw() : array
    {
        return $this->progress;
    }

    public function setForUser(?int $user_id) : ProgressWrapperInterface
    {
        if($user_id && isset($this->progress[$user_id]))
        {
            $this->current_user_progress = $this->progress[$user_id];
        }

        return $this;
    }

    public function getCurrentUserProgress() : array
    {
        return $this->current_user_progress;
    }

    public function getFor(int $id) : ?int
    {
        if(isset($this->current_user_progress[$id]))
        {
            return $this->current_user_progress[$id]*$this->percentage;
        }

        return null;
    }

    public function biggerThan(int $id, int $value) : bool
    {
        if(isset($this->current_user_progress[$id]) && ($this->current_user_progress[$id]*$this->percentage) > $value)
        {
            return true;
        }

        return false;
    }

    public function equalTo(int $id, int $value) : bool
    {
        if(isset($this->current_user_progress[$id]) && ($this->current_user_progress[$id]*$this->percentage) === $value)
        {
            return true;
        }

        return false;
    }

    public function checkFullyCompleted() : bool
    {
        return array_sum($this->current_user_progress) === count($this->current_user_progress) && !empty($this->current_user_progress) ;
    }

    public function checkNoneStarted() : bool
    {
        return array_sum($this->current_user_progress) === 0;
    }
}
