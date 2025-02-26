<?php

namespace App\Livewire\Inquiry;

use App\UseCases\Inquiry\ShowUseCase;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class ShowInquiry extends Component
{
    /**
     * @var Collection<int, \App\Models\Inquiry>
     */
    public Collection $inquiries;

    private ShowUseCase $showUseCase;

    public function boot(ShowUseCase $showUseCase): void
    {
        $this->showUseCase = $showUseCase;
    }

    public function mount(): void
    {
        $this->inquiries = ($this->showUseCase)();
    }

    public function render(): View
    {
        return view('livewire.inquiry.show-inquiry');
    }
}
