<?php

namespace App\View\Components\client;

use Illuminate\View\Component;

class RandomGradientContainer extends Component
{
    public ?string $classes;
    public string $gradient_1;
    public string $gradient_2;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(?string $classes)
    {
        $this->classes = $classes ?? '';
        $this->gradient_1 = rand(200, 255).', '.rand(200, 255).', '.rand(200, 255);
        $this->gradient_2 = rand(200, 255).', '.rand(200, 255).', '.rand(200, 255);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.client.random-gradient-container');
    }
}
