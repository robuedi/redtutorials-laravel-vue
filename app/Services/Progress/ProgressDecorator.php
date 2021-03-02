<?php


namespace App\Services\Progress;

abstract class ProgressDecorator implements Progress
{
    protected Progress $sub_section;
    protected array $ids;

    public function __construct(Progress $sub_section)
    {
        $this->sub_section = $sub_section;
    }

    public function setIDs(array $ids): Progress
    {
        $this->sub_section->setIDs($ids);
    }

    public function setUserID(?int $user_id): Progress
    {
        $this->sub_section->setUserID($user_id);
    }

    public function getProgress(): array
    {
        return $this->sub_section->getProgress();
    }

    public function getIDs() : array
    {
        return $this->sub_section->getIDs();
    }

}
