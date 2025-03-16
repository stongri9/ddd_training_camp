<?php

namespace app\Livewire\Inquiry;

use app\Livewire\Forms\Inquiry\CreateForm;
use app\UseCases\Inquiry\CreateUseCase;
use app\UseCases\Inquiry\CreateUseCaseDto;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Create extends Component
{
    public CreateForm $form;

    private CreateUseCase $createUseCase;

    public function boot(CreateUseCase $createUseCase): void
    {
        $this->createUseCase = $createUseCase;
    }

    public function execute(): void
    {
        $this->validate();

        $dto = CreateUseCaseDto::create(
            ...$this->form->all(),
        );
        ($this->createUseCase)($dto);

        session()->flash('status', 'Post successfully updated.');

        $this->redirect('/inquiry');
    }

    public function render(): View
    {
        return view('livewire.inquiry.create');
    }
}
