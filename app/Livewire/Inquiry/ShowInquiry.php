<?php

namespace App\Livewire\Inquiry;

use App\UseCases\Inquiry\ShowUseCase;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class ShowInquiry extends Component
{
    /**
     * @var Collection<\App\Models\Inquiry>
     */
    public Collection $inquiries;

    /**
     * @var ShowUseCase
     */
    private ShowUseCase $showUseCase;

    /**
     * @param ShowUseCase $showUseCase
     * @return void
     */
    public function boot(ShowUseCase $showUseCase): void
    {
        $this->showUseCase = $showUseCase;
    }
    
    /**
     * @return void
     */
    public function mount(): void
    {
        $this->inquiries = ($this->showUseCase)();
    }

    /**
     * @return View
     */
    public function render(): View
    {
        return view('livewire.inquiry.show-inquiry');
    }
}
