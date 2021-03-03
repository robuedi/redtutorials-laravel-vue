<?php

namespace App\View\Components\client;

use Illuminate\View\Component;

class LessonSectionItem extends Component
{
    public array $lesson_sections_status;
    public $lesson_section;
    public int $current_status;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(array $lesson_sections_status, $lesson_section)
    {
        $this->lesson_section = $lesson_section;
        $this->lesson_sections_status = $lesson_sections_status;
    }



    public function checkLessonSectionType()
    {

    }

    public function checkIfActive()
    {

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.client.lesson-section-item');
    }
}
