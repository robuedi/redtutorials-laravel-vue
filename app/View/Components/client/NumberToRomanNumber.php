<?php

namespace App\View\Components\client;

use App\Services\NumericHelper\NumericHelperInterface;
use Illuminate\View\Component;

class NumberToRomanNumber extends Component
{
    public int $number;
    public string $roman_number;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(int $number, NumericHelperInterface $numeric_service)
    {
        $this->number       = $number;
        $this->roman_number = $numeric_service->numberToRomanRepresentation($number);
    }


    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.client.number-to-roman-number');
    }
}
