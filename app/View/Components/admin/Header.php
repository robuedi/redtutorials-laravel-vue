<?php

namespace App\View\Components\admin;

use App\Services\Authentication\AuthenticationHelperInterface;
use Illuminate\View\Component;

class Header extends Component
{
    public $user_name;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(AuthenticationHelperInterface $authentication_helper)
    {
        $this->user_name = $authentication_helper->getUserName();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.admin.header');
    }
}
