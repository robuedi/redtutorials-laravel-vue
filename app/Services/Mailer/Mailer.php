<?php


namespace App\Services\Mailer;

use Illuminate\Support\Facades\Mail;

class Mailer implements MailerInterface
{
    public function sendActivationEmail(string $activation_url, string $email, string $first_name, string $last_name)
    {
        //send email reset code
        Mail::send('emails.activate-account', ['activation_url' => $activation_url, 'first_name' => $first_name], function ($m) use ($email, $first_name, $last_name) {
            $m->from('no-reply@redtutorial.com', config('app.name'));
            $m->to($email, $first_name.''.$last_name)->subject('Activate Account');
        });
    }
}
