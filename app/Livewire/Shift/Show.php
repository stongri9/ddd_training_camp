<?php

namespace app\Livewire\Shift;

use app\UseCases\Shift\ShowUseCase;
use app\UseCases\Shift\ShowUseCaseDto;
use DateTimeImmutable;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Livewire\Component;

class Show extends Component
{
    /**
     * @var Collection<int, \app\Domains\Shift\Shift>
     */
    public Collection $shifts;

    public int $year;

    public int $month;

    private ShowUseCase $showUseCase;

    public function boot(ShowUseCase $showUseCase): void
    {
        $this->showUseCase = $showUseCase;
    }

    public function mount(): void
    {
        $now = new DateTimeImmutable;
        $this->year = $this->year ?? (int) $now->format('Y');
        $this->month = $this->month ?? (int) $now->format('m');

        $dto = ShowUseCaseDto::create($this->year, $this->month);

        $this->shifts = ($this->showUseCase)($dto);
    }

    public function render(): View
    {
        return view('livewire.shift.show');
    }
}
