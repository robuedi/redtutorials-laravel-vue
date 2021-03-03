<?php


namespace App\Repositories\Repositories;

use App\Models\ContactMessageUser;
use App\Repositories\ContactMessageUserRepositoryInterface;

class ContactMessageUserRepository implements ContactMessageUserRepositoryInterface
{
    public function getCountUserUnreadMsg(?int $user_id)
    {
        if(!is_int($user_id))
        {
            return null;
        }

        return ContactMessageUser::where('user_id', $user_id)
            ->where('is_deleted', 0)
            ->where('is_read', 0)
            ->count();
    }

}
