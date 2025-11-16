<?php

namespace App\View\Components;

use Illuminate\View\Component;

class MainMetrics extends Component
{
    public $metrics;

    public function __construct($metrics)
    {
        $this->metrics = $metrics;
    }

    public function render()
    {
        return view('components.main-metrics');
    }
}
