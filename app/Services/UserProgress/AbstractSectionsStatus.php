<?php


namespace App\Services\UserProgress;


abstract class AbstractSectionsStatus
{
    protected array $ids;
    protected ?int $user_id;
    protected array $response;
    protected bool $floor_rounded;

    public function setIDs(array $ids = [])
    {
        $this->ids = $ids;
        return $this;
    }

    public function setUserID(?int $user_id)
    {
        $this->user_id = $user_id;
        return $this;
    }

    public function setFloorRounded(bool $floor_rounded)
    {
        $this->floor_rounded = $floor_rounded;
        return $this;
    }

    public function getStatus()
    {
        if(!isset($this->response))
        {
            $this->makeStatus();
        }

        //round values?
        if($this->floor_rounded)
        {
            array_walk($this->response, function (&$value) {
                $value = (int)$value;
            });
        }

        return $this->response;
    }
}
