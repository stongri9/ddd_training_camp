<?php

namespace App\Livewire\Inquiry;

use App\UseCases\Inquiry\CreateUseCaseDto;
use App\UseCases\Inquiry\ShowUseCase as InquiryShowUseCase;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\View;
use Livewire\Component;

class ShowInquiry extends Component
{
    /**
     * @var Collection
     */
    public Collection $inquiries;

    /**
     * @var InquiryShowUseCase
     */
    private InquiryShowUseCase $inquiryShowUseCase;

    /**
     * @param \App\UseCases\Inquiry\ShowUseCase $inquiryShowUseCase
     * @return void
     */
    public function boot(InquiryShowUseCase $inquiryShowUseCase): void {
        $this->inquiryShowUseCase = $inquiryShowUseCase;
    }

    public function mount(): void 
    {
        $this->inquiries = ($this->inquiryShowUseCase)();
    }

    /**
     * @return \Illuminate\View\View
     */
    public function render(): View
    {
        return view('livewire.inquiry.show-inquiry');
    }
}
