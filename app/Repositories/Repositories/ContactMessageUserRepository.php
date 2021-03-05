<?php


namespace App\Repositories\Repositories;

use App\Models\ContactMessageUser;
use App\Repositories\ContactMessageUserRepositoryInterface;

class ContactMessageUserRepository implements ContactMessageUserRepositoryInterface
{
    private ContactMessageUser $contact_message_to_user;

    public function __construct(ContactMessageUser $contact_message_to_user)
    {
        $this->contact_message_to_user = $contact_message_to_user;
    }

    public function getCountUserUnreadMsg(?int $user_id)
    {
        if(!is_int($user_id))
        {
            return null;
        }

        return $this->contact_message_to_user->where('user_id', $user_id)
            ->where('is_deleted', 0)
            ->where('is_read', 0)
            ->count();
    }

}
