<?php

namespace App\Livewire\Inquiry;

use App\Livewire\Forms\Inquiry\CreateInquiryForm;
use App\UseCases\Inquiry\CreateUseCase as InquiryCreateUseCase;
use App\UseCases\Inquiry\CreateUseCaseDto;
use Illuminate\View\View;
use Livewire\Component;

class CreateInquiry extends Component
{
    public CreateInquiryForm $form;

    private InquiryCreateUseCase $inquiryCreateUseCase;

    public function boot(InquiryCreateUseCase $inquiryCreateUseCase): void
    {
        $this->inquiryCreateUseCase = $inquiryCreateUseCase;
    }

    public function execute(): void
    {
        $this->validate();

        $dto = CreateUseCaseDto::create(
            ...$this->form->all(),
        );
        ($this->inquiryCreateUseCase)($dto);

        session()->flash('status', 'Post successfully updated.');

        $this->redirect('/inquiry');
    }

    public function render(): View
    {
        return view('livewire.inquiry.create-inquiry');
    }
}
