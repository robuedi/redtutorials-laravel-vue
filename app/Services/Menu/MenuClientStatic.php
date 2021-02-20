<?php
/**
 * Created by PhpStorm.
 * User: eduard
 * Date: 08/10/18
 * Time: 21:37
 */

namespace App\Services\Menu;


use App\StaticPage;

class MenuClientStatic
{
    static function getStaticMenu()
    {
        $pages = StaticPage::where('slug', '!=', '')
                    ->where('is_public', 1)
                    ->get();

        return $pages;
    }
}
