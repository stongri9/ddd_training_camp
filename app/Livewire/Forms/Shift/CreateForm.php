<?php

namespace App\Livewire\Forms\Shift;

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
}
