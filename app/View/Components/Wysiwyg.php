<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class Wysiwyg extends Component
{

    public function __construct()
    {
    }

    public function render(): View
    {
        return view('components.wysiwyg');
    }
}
