<?php

namespace app\Livewire\Inquiry;

use app\Livewire\Forms\Inquiry\UpdateForm;
use app\UseCases\Inquiry\EditUseCase as InquiryEditUseCase;
use app\UseCases\Inquiry\UpdateUseCase as InquiryUpdateUseCase;
use app\UseCases\Inquiry\UpdateUseCaseDto;
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
