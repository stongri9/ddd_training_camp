<?php

namespace app\Livewire\Shift;

use app\UseCases\Shift\ShowUseCase;
use app\UseCases\Shift\ShowUseCaseDto;
use DateTime;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Livewire\Component;

class Show extends Component
{
    /**
     * @var Collection<int, \app\Domains\Shift\Shift>
     */
    public Collection $shifts;

    public string $current_start_date;

    public string $current_end_date;

    private ShowUseCase $showUseCase;

    public function boot(ShowUseCase $showUseCase): void
    {
        $this->showUseCase = $showUseCase;
    }

    public function mount(): void
    {
        $now = new DateTime;
        $this->current_start_date = $now->format('Y-m-01');
        $this->current_end_date = $now->format('Y-m-t');

        $dto = ShowUseCaseDto::create($this->current_start_date, $this->current_end_date, true);

        $this->shifts = ($this->showUseCase)($dto);
    }

    public function render(): View
    {
        return view('livewire.shift.show');
    }
}
