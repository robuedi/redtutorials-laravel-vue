<?php
/**
 * Created by PhpStorm.
 * User: eduard
 * Date: 17/10/18
 * Time: 16:57
 */

namespace App\Services\Menu;


use App\ContactMessageToUser;
use App\Repositories\ContactMessageUserRepositoryInterface;
use App\Services\Authentication\AuthenticationHelperInterface;
use Sentinel;

class MenuUserContactMessages implements MenuUserContactMessagesInterface
{
    private $unread_msg_nr = null;
    private AuthenticationHelperInterface $authentication_helper;
    private ContactMessageUserRepositoryInterface $contact_message_user_repository;

    public function __construct(AuthenticationHelperInterface $authentication_helper, ContactMessageUserRepositoryInterface $contact_message_user_repository)
    {
        $this->authentication_helper = $authentication_helper;
        $this->contact_message_user_repository = $contact_message_user_repository;
    }

    private function checkUnreadMsgNr()
    {
        //check if we get the nr of msg
        if($this->unread_msg_nr !== null)
        {
            return;
        }

        //get the nr of msg
        $user_id = $this->authentication_helper->getUserId();

        if($user_id)
        {
            //get number of unread messages
            $this->unread_msg_nr =  $this->contact_message_user_repository->getCountUserUnreadMsg($user_id);
        }
    }

    public function getLoggedUserUnreadMsgNr()
    {
        $this->checkUnreadMsgNr();
        return $this->unread_msg_nr;
    }

}
