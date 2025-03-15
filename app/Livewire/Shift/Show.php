<?php

namespace app\Livewire\Shift;

use app\UseCases\Shift\ShowUseCase;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class Show extends Component
{
    /**
     * @var Collection<int, \app\Models\Shift>
     */
    public Collection $shifts;

    private ShowUseCase $showUseCase;

    public function boot(ShowUseCase $showUseCase): void
    {
        $this->showUseCase = $showUseCase;
    }

    public function mount(): void
    {
        $this->shifts = ($this->showUseCase)();
    }

    public function render(): View
    {
        return view('livewire.shift.show');
    }
}
