<?php


namespace App\Services\Authentication\Components;

use Cartalyst\Sentinel\Laravel\Facades\Activation;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Support\Facades\Mail;

class AuthenticationRegister implements AuthenticationRegisterInterface
{
    public function register(string $user_type, array $user_info, string $base_activation_url)
    {
        $response = [
            'status'    => 'fail',
            'msg'       => ''
        ];

        //get role
        $role = Sentinel::findRoleBySlug($user_type);

        if(!$role)
        {
            $response['msg'] = 'Role missing';
            return $response;
        }

        //register
        $user = Sentinel::register($user_info);
        $user->save();

        // assign user to  role
        $role->users()->attach($user);

        //make activation url
        $activation_url = $base_activation_url.'/'.$user->id.'/'.Activation::create($user);

        //send email reset code
        Mail::send('emails.activate_account', ['activation_url' => $activation_url, 'user' => $user], function ($m) use ($user) {
            $m->from('no-reply@redtutorial.com', config('app.name'));
            $m->to($user->email, $user->first_name.''.$user->last_name)->subject('Activate Account');
        });

        return [
            'status'            => 'success'
        ];
    }
}
