<?php


namespace App\Services\UserProgress;


abstract class AbstractSectionsStatus implements AbstractSectionsStatusInterface
{
    protected array $ids;
    protected ?int $user_id;
    protected array $response;
    protected bool $floor_rounded = true;

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

    public function getIDs() : ?array
    {
        return $this->ids ?? null;
    }

    public function getUserID() : ?int
    {
        return $this->user_id ?? null;
    }

    public function getFloorRounded() : ?bool
    {
        return $this->floor_rounded ?? null;
    }

    protected abstract function makeStatus();

    public function getStatus()
    {
        if(!isset($this->response))
        {
            $this->makeStatus();
        }

        if(!isset($this->response))
        {
            return [];
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
