<?php

namespace app\Livewire\Shift;

use app\Livewire\Forms\Shift\UpdateForm;
use app\UseCases\Shift\ShowUseCase;
use app\UseCases\Shift\ShowUseCaseDto;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Livewire\Attributes\Url;
use Livewire\Component;

class Update extends Component
{
    public UpdateForm $form;

    /**
     * @var Collection<int, \app\Domains\Shift\Shift>
     */
    public Collection $shifts;

    #[Url]
    public string $start_date;

    #[Url]
    public string $end_date;

    #[Url]
    public bool $is_published_edit;

    private ShowUseCase $showUseCase;

    public function boot(
        ShowUseCase $showUseCase
    ): void {
        $this->showUseCase = $showUseCase;
    }

    public function mount(
    ): void {
        $dto = ShowUseCaseDto::create(
            $this->start_date,
            $this->end_date,
            $this->is_published_edit,
        );

        $this->shifts = ($this->showUseCase)($dto);
    }

    public function render(): View
    {
        return view('livewire.shift.update');
    }
}
