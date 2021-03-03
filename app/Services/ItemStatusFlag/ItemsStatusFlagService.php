<?php


namespace App\Services;

class ItemsStatusFlagService implements ItemsStatusFlagServiceInterface
{
    private bool $currently_active = false;

    public function checkFlag(?int $status)
    {
        //check if we already marked as active another chapter
        if($status === null || $this->currently_active)
        {
            return 'inactive';
        }

        //chapter not completed so we mark as active
        if($status !== 100)
        {
            $this->currently_active = true;
            return 'active';
        }

        return 'inactive';
    }
}
