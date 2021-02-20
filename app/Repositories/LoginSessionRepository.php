<?php


namespace App\Repositories;

use App\Models\Login;
use App\Services\Authentication\AuthenticationServiceInterface;

class LoginSessionRepository implements LoginSessionRepositoryInterface
{
    public function saveLogin(int $user_id) : void
    {
        /// insert in BD and in session login_id
        // if we are here, that means it's a successful login
        $new_login                = new Login;
        $new_login->user_id       = $user_id;
        $new_login->login_date    = date('Y-m-d H:i:s');
        $new_login->login_success = 1;
        $new_login->login_ip      = request()->getClientIp();

        $request                  = request()->server();
        $new_login->browser       = $request['HTTP_USER_AGENT'] ?? '';
        $new_login->save();

        // store in session the current login history id
        session(['login_history_id' => $new_login->login_id]);
    }

    public function saveLogout() : void
    {
        $login_history_id = session('login_history_id');

        // make sure the session contains something
        if (!$login_history_id) {
            return;
        }

        $login = Login::find($login_history_id);

        // only update the logout date if the record is found
        if (!$login) {
            return;
        }

        $login->logout_date = date('Y-m-d H:i:s');
        $login->save();
    }

}
