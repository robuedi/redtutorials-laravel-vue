<?php

namespace App\View\Components\admin;

use App\Services\Authentication\AuthenticationServiceInterface;
use App\Services\Menu\MenuAdminInterface;
use App\Services\Menu\MenuUserContactMessagesInterface;
use Illuminate\View\Component;

class Nav extends Component
{
    public $user_name;
    public $current_user_unread_msg_nr;
    public $config_menu;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(AuthenticationServiceInterface $authentication_service, MenuUserContactMessagesInterface $menu_user_contact_messages, MenuAdminInterface $menu_admin)
    {
        $this->user_name = $authentication_service->getUserName();
        $this->current_user_unread_msg_nr = $menu_user_contact_messages->getLoggedUserUnreadMsgNr();
        $this->config_menu = $menu_admin->getMenu();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.admin.nav');
    }
}
