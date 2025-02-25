<?php

namespace App\Livewire\Inquiry;

use App\Livewire\Forms\Inquiry\UpdateInquiryForm;
use App\UseCases\Inquiry\EditUseCase as InquiryEditUseCase;
use App\UseCases\Inquiry\UpdateUseCase as InquiryUpdateUseCase;
use App\UseCases\Inquiry\UpdateUseCaseDto;
use Illuminate\View\View;
use Livewire\Component;

class UpdateInquiry extends Component
{
    public UpdateInquiryForm $form;

    private InquiryEditUseCase $inquiryEditUseCase;

    private InquiryUpdateUseCase $inquiryUpdateUseCase;

    public function boot(
        InquiryEditUseCase $inquiryEditUseCase,
        InquiryUpdateUseCase $inquiryUpdateUseCase
    ): void {
        $this->inquiryEditUseCase = $inquiryEditUseCase;
        $this->inquiryUpdateUseCase = $inquiryUpdateUseCase;
    }

    public function mount(int $id): void
    {
        $this->form->setInquiry(($this->inquiryEditUseCase)($id));
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
