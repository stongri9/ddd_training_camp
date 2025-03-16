<?php

namespace app\Livewire\Shift;

use App\Livewire\Forms\Shift\CreateForm;
use app\UseCases\Shift\CreateUseCase;
use app\UseCases\Shift\CreateUseCaseDto;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Create extends Component
{
    public CreateForm $form;

    private CreateUseCase $createUsecase;

    public function boot(
        CreateUseCase $createUsecase,
    ): void {
        $this->createUsecase = $createUsecase;
    }

    public function execute(): void
    {
        $this->validate();
        $dto = CreateUseCaseDto::create(
            ...$this->form->all(),
        );

        try {
            ($this->createUsecase)($dto);
        } catch (\Error $e) {
            session()->flash('error', $e->getMessage());
            $this->redirect(route('shift'));

            return;
        }

        session()->flash('success', 'シフト作成が完了しました.');

        $this->redirect(
            route('shift.edit', [
                'start_date' => $this->form->start_date,
                'end_date' => $this->form->end_date,
            ], false));

    }

    public function render(): View
    {
        return view('livewire.shift.create');
    }
}
