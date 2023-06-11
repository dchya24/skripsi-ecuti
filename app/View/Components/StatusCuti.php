<?php

namespace App\View\Components;

use App\Enums\StatusCuti as EnumsStatusCuti;
use Illuminate\View\Component;

class StatusCuti extends Component
{
    public $status;
    public $style;
    public $message;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($status)
    {
        $this->status = $status;
        $this->style = $status ? EnumsStatusCuti::STYLE[$status] : null;
        $this->message = $status ? EnumsStatusCuti::OPTIONS[$status] : null;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.status-cuti');
    }
}
