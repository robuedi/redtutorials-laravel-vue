<?php
/**
 * Created by PhpStorm.
 * User: eduard
 * Date: 17/10/18
 * Time: 16:57
 */

namespace App\Services\Menu;


use App\ContactMessageToUser;
use Sentinel;

class MenuUserContactMessages
{
    private static $unread_msg_nr = 0;

    public static function currentUserUnreadMsgNr()
    {
        $user = Sentinel::getUser();

        if($user)
        {
            //get number of unread messages
            $unread_messages = ContactMessageToUser::where('user_id', $user->id)
                ->where('is_deleted', 0)
                ->where('is_read', 0)
                ->count();

            self::$unread_msg_nr = $unread_messages;

            return $unread_messages;
        }

        return 0;
    }

    public static function getUnreadMsgNr()
    {
        return self::$unread_msg_nr;
    }

}
