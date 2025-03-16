<?php

namespace App\Livewire\Shift;

use App\Livewire\Forms\Shift\ApplyForm;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Apply extends Component
{
    public ApplyForm $form;

    // private ShiftEditUseCase $shiftEditUseCase;

    // private ShiftUpdateUseCase $shiftUpdateUseCase;

    public function boot(
        // ShiftEditUseCase $shiftEditUseCase,
        // ShiftUpdateUseCase $shiftUpdateUseCase,
    ): void {
        // $this->shiftEditUseCase = $shiftEditUseCase;
        // $this->shiftUpdateUseCase = $shiftUpdateUseCase;
    }

    public function mount(int $id): void
    {
        // $shift = ($this->shiftEditUseCase)($id);

        // if (!$shift) {
        //     return;
        // }

        $this->form->setShift(
            // $shift,
        );
    }

    public function execute(): void
    {
        $this->validate();

        // $dto = UpdateUseCaseDto::create(
        //     ...$this->form->all(),
        // );
        // ($this->shiftUpdateUseCase)($dto);

        session()->flash('status', 'Post successfully updated.');

        $this->redirect('/shift');
    }

    public function render(): View
    {
        return view('livewire.shift.apply');
    }
}
