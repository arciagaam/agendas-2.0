<?php

namespace App\View\Components\navigation;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class navaccordion extends Component
{
    public $label, $name;
    /**
     * Create a new component instance.
     */
    public function __construct(string $label, string $name)
    {
        $this->label = $label;
        $this->name = $name;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.navigation.navaccordion');
    }
}
