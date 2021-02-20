<?php

namespace App\View\Components\client;

use App\Repositories\StaticPageRepositoryInterface;
use Illuminate\View\Component;

class Footer extends Component
{
    public $static_menu;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(StaticPageRepositoryInterface $static_page_repository)
    {
        $this->static_menu = $static_page_repository->getStaticMenu();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.client.footer');
    }
}
