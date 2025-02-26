<?php

namespace App\Livewire\Inquiry;

use App\Livewire\Forms\Inquiry\CreateForm;
use App\UseCases\Inquiry\CreateUseCase;
use App\UseCases\Inquiry\CreateUseCaseDto;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class CreateInquiry extends Component
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
        return view('livewire.inquiry.create-inquiry');
    }
}
