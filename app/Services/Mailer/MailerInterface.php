<?php

namespace App\Services\Mailer;

interface MailerInterface
{
    public function sendActivationEmail(string $activation_url, string $email, string $first_name, string $last_name);
}
