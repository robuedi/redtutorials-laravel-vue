<?php

namespace App\Repositories;

interface ContactMessageUserRepositoryInterface
{
    public function getCountUserUnreadMsg(?int $user_id);
}
