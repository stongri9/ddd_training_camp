<?php

namespace app\Livewire\Shift;

use app\UseCases\Shift\ShowUseCase;
use app\UseCases\Shift\ShowUseCaseDto;
use DateTime;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Livewire\Attributes\Url;
use Livewire\Component;

class ShowUnpublished extends Component
{
    /**
     * @var Collection<int, \app\Domains\Shift\Shift>
     */
    public Collection $shifts;

    #[Url]
    public string $latest_date;

    public string $start_date;

    public string $end_date;

    private ShowUseCase $showUseCase;

    public function boot(
        ShowUseCase $showUseCase,
    ): void {
        $this->showUseCase = $showUseCase;
    }

    public function mount(): void
    {
        $datetime = new DateTime($this->latest_date);
        $datetime->modify('+1 day');
        $this->start_date = $datetime->format('Y-m-d');
        $this->end_date = $datetime->format('Y-m-t');
        $dto = ShowUseCaseDto::create(
            $this->start_date,
            $this->end_date,
            false,
        );

        $this->shifts = ($this->showUseCase)($dto);
    }

    public function render(): View
    {
        return view('livewire.shift.show-unpublished');
    }
}
