<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class PetugasLayout extends Component
{
    public function render(): View
    {
        return view('layouts.petugas');
    }
}
