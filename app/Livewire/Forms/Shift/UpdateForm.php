<?php

namespace App\Livewire\Forms\Shift;

// use App\Models\Shift;
use Livewire\Attributes\Validate;
use Livewire\Form;

class UpdateForm extends Form
{
    /**
     * @var string
     */
    #[Validate('required')]
    public $comment = '';

    public function setShift(
        // Shift $shift
    ): void {}
}
