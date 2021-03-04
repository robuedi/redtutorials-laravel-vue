<?php

namespace App\View\Components\client;

use App\Services\LessonSectionStatus\LessonSectionStatus;
use App\Services\LessonSectionStatus\LessonSectionStatusInterface;
use App\Services\Progress\Wrapper\ProgressWrapperInterface;
use Illuminate\Support\Facades\Log;
use Illuminate\View\Component;

class LessonProgressBtn extends Component
{
    public ?string $name;
    public string $type;
    public ProgressWrapperInterface $progress;
    public int $status;
    public int $id;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(int $id, ?string $name, string $type, ProgressWrapperInterface $progress, LessonSectionStatusInterface $lesson_section_status)
    {
        $this->name = $name;
        $this->type = $type;
        $this->id = $id;
        $this->progress = $progress;
        $this->status = $lesson_section_status->checkStatus($progress, $id, $type);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.client.lesson-progress-btn');
    }
}
