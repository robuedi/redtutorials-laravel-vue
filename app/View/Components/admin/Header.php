<?php

namespace App\View\Components\admin;

use App\Services\Authentication\AuthenticationServiceInterface;
use Illuminate\View\Component;

class Header extends Component
{
    public $user_name;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(AuthenticationServiceInterface $authentication_service)
    {
        $this->user_name = $authentication_service->getUserName();
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
