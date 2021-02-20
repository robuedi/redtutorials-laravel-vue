<?php

namespace App\Services\Menu;

use App\Services\Authentication\AuthenticationServiceInterface;
use Config;
use function foo\func;
use Log;
use Request;
use Sentinel;

class MenuAdmin implements MenuAdminInterface
{
    private $authentication_service;

    public function __construct(AuthenticationServiceInterface $authentication_service)
    {
        $this->authentication_service = $authentication_service;
    }

    public function getMenu()
    {
        $current_url = request()->path();

        $url_items = explode('/', $current_url);

        // get all menu structure
        $menu = config('menu');

        //update routes, make them dynamic
        array_walk_recursive(
            $menu,
            function (&$value, $key) {
                if ($key === 'url' && $value !== '#' && !empty($value)) {
                    $value = config('app.admin_route').$value;
                }
            }
        );

        // filter menu based on current user type
        if ($this->authentication_service->checkIfAdmin() === 'yes')
            $menu = $menu['admin'];

        foreach ($menu as $top_level_menu_key => $top_level_menu)
        {
            if ($current_url == $top_level_menu['url']) {
                $menu[$top_level_menu_key]['active'] = true;
                break;
            }

            if (isset($url_items[0]) && $url_items[0] == $top_level_menu['url'])
            {
                $menu[$top_level_menu_key]['active'] = true;
                break;
            }
            elseif (isset($top_level_menu['aliases']) && count($top_level_menu['aliases']))
            {
                //looping aliases
                foreach ($top_level_menu['aliases'] as $alias)
                {
                    preg_match('/'.$alias.'/', $current_url, $found_items);

                    if (count($found_items))
                    {
                        $menu[$top_level_menu_key]['active'] = true;
                        break;
                    }
                }
            }

            //looping top menus
            if (isset($top_level_menu['submenus']) && count($top_level_menu['submenus']))
            {

                //looping submenus
                foreach ($top_level_menu['submenus'] as $second_level_menu_key => $second_level_menu)
                {

                    if ($current_url == $second_level_menu['url'])
                    {
                        $menu[$top_level_menu_key]['submenus'][$second_level_menu_key]['active'] = true;
                        $menu[$top_level_menu_key]['active'] = true;
                        break;
                    }
                    elseif (isset($second_level_menu['aliases']) && count($second_level_menu['aliases']))
                    {
                        //looping aliases
                        foreach ($second_level_menu['aliases'] as $alias)
                        {
                            preg_match('/'.$alias.'/', $current_url, $found_items);

                            if (count($found_items))
                            {
                                $menu[$top_level_menu_key]['submenus'][$second_level_menu_key]['active'] = true;
                                $menu[$top_level_menu_key]['active'] = true;
                                break;
                            }
                        }
                    }
                }
            }
        }

        return $menu;
    }
}
