<?php

namespace App\Livewire\Forms\Shift;

use DateTimeInterface;
use Livewire\Attributes\Validate;
use Livewire\Form;

class CreateForm extends Form
{
    /**
     * @var string
     */
    #[Validate('required')]
    public $start_date = '';

    /**
     * @var string
     */
    #[Validate('required')]
    public $end_date = '';

    public function toStringDateProperty(): void 
    {
        if (is_a($this->start_date, DateTimeInterface::class)) {
            $this->start_date = $this->start_date->format('Y-m-d');
        }
        if (is_a($this->end_date, DateTimeInterface::class)) {
            $this->end_date = $this->end_date->format('Y-m-d');
        }
    }
}
