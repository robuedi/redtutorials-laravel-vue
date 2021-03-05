<?php


namespace App\Repositories\Repositories;

use App\Models\Login;
use App\Repositories\LoginSessionRepositoryInterface;

class LoginSessionRepository implements LoginSessionRepositoryInterface
{
    private Login $login;

    public function __construct(Login $login)
    {
        $this->login = $login;
    }

    public function saveLogin(int $user_id) : void
    {
        /// insert in BD and in session login_id
        // if we are here, that means it's a successful login
        $this->login->user_id       = $user_id;
        $this->login->login_date    = date('Y-m-d H:i:s');
        $this->login->login_success = 1;
        $this->login->login_ip      = request()->getClientIp();

        $request                  = request()->server();
        $this->login->browser       = $request['HTTP_USER_AGENT'] ?? '';
        $this->login->save();

        // store in session the current login history id
        session(['login_history_id' => $this->login->login_id]);
    }

    public function saveLogout() : void
    {
        $login_history_id = session('login_history_id');

        // make sure the session contains something
        if (!$login_history_id) {
            return;
        }

        $login = $this->login->find($login_history_id);

        // only update the logout date if the record is found
        if (!$login) {
            return;
        }

        $login->logout_date = date('Y-m-d H:i:s');
        $login->save();
    }

}
