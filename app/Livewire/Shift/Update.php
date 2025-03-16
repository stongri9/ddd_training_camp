<?php

namespace app\Livewire\Shift;

use App\Livewire\Forms\Shift\UpdateForm;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Update extends Component
{
    public function render(): View
    {
        return view('livewire.shift.update');
    }
}
