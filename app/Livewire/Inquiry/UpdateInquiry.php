<?php

namespace App\Livewire\Inquiry;

use App\Livewire\Forms\Inquiry\UpdateForm;
use App\UseCases\Inquiry\EditUseCase as InquiryEditUseCase;
use App\UseCases\Inquiry\UpdateUseCase as InquiryUpdateUseCase;
use App\UseCases\Inquiry\UpdateUseCaseDto;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class UpdateInquiry extends Component
{
    public UpdateForm $form;

    private InquiryEditUseCase $inquiryEditUseCase;

    private InquiryUpdateUseCase $inquiryUpdateUseCase;

    public function boot(
        InquiryEditUseCase $inquiryEditUseCase,
        InquiryUpdateUseCase $inquiryUpdateUseCase,
    ): void {
        $this->inquiryEditUseCase = $inquiryEditUseCase;
        $this->inquiryUpdateUseCase = $inquiryUpdateUseCase;
    }

    public function mount(int $id): void
    {
        $inquiry = ($this->inquiryEditUseCase)($id);

        if (! $inquiry) {
            return;
        }

        $this->form->setInquiry($inquiry);
    }

    public function execute(): void
    {
        $this->validate();

        $dto = UpdateUseCaseDto::create(
            ...$this->form->all(),
        );
        ($this->inquiryUpdateUseCase)($dto);

        session()->flash('status', 'Post successfully updated.');

        $this->redirect('/inquiry');
    }

    public function render(): View
    {
        return view('livewire.inquiry.update-inquiry');
    }
}
