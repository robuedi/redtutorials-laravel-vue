<?php


namespace App\Services\UserProgress;


abstract class AbstractSectionsStatus implements AbstractSectionsStatusInterface
{
    protected ?array $ids;
    protected ?int $user_id;
    protected ?array $response;

    public function setIDs(?array $ids) : AbstractSectionsStatusInterface
    {
        $this->ids = $ids;
        return $this;
    }

    public function setUserID(?int $user_id) : AbstractSectionsStatusInterface
    {
        $this->user_id = $user_id;
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

    protected abstract function makeStatus();

    public function getFreshStatus(bool $floor_rounded = false)
    {
        unset($this->response);
        return $this->getStatus($floor_rounded);
    }

    public function getStatus(bool $floor_rounded = false)
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
        if(!$floor_rounded)
        {
            array_walk($this->response, function (&$value) {
                $value = (int)$value;
            });
        }

        return $this->response;
    }


}
