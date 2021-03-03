<?php


namespace App\Services\Progress\Wrapper;


class ProgressWrapper implements ProgressWrapperInterface
{
    private array $progress;
    private array $current_user_progress = [];
    private bool $percentage = false;

    public function setProgress(array $progress)
    {
        $this->progress = $progress;
        return $this;
    }

    public function setPercentage(bool $percentage)
    {
        $this->percentage = $percentage;
        return $this;
    }

    public function getRaw()
    {
        return $this->progress;
    }

    public function setForUser(?int $user_id)
    {
        if($user_id && isset($this->progress[$user_id]))
        {
            $this->current_user_progress = $this->progress[$user_id];
        }

        return $this;
    }

    public function getFor(int $id) : ?int
    {
        if(isset($this->current_user_progress[$id]))
        {
            return $this->percentage ? $this->current_user_progress[$id]*100 : $this->current_user_progress[$id];
        }

        return null;
    }

    public function biggerThan(int $id, int $value)
    {
        if(isset($this->current_user_progress[$id]) && $this->current_user_progress[$id] > $value)
        {
            return true;
        }

        return false;
    }

    public function equalTo(int $id, int $value)
    {
        if(isset($this->current_user_progress[$id]) && $this->current_user_progress[$id] === $value)
        {
            return true;
        }

        return false;
    }
}
