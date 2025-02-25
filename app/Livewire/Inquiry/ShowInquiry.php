<?php

namespace App\Livewire\Inquiry;

use App\UseCases\Inquiry\ShowUseCase as InquiryShowUseCase;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\View;
use Livewire\Component;

class ShowInquiry extends Component
{
    public Collection $inquiries;

    private InquiryShowUseCase $inquiryShowUseCase;

    public function boot(InquiryShowUseCase $inquiryShowUseCase): void
    {
        $this->inquiryShowUseCase = $inquiryShowUseCase;
    }

    public function mount(): void
    {
        $this->inquiries = ($this->inquiryShowUseCase)();
    }

    public function render(): View
    {
        return view('livewire.inquiry.show-inquiry');
    }
}
