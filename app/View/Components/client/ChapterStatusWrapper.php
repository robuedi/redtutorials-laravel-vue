<?php

namespace App\View\Components\client;

use App\Services\ItemsStatusFlagServiceInterface;
use Illuminate\View\Component;

class ChapterStatusWrapper extends Component
{
    public ?int $status;
    public string $status_flag;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(?int $status, ItemsStatusFlagServiceInterface $items_status_flag_service)
    {
        $this->status = $status;
        $this->status_flag = $items_status_flag_service->checkFlag($status);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.client.chapter-status-wrapper');
    }
}
