<?php

namespace app\Livewire\Forms\Shift;

use Livewire\Attributes\Validate;
use Livewire\Form;

class CreateForm extends Form
{
    /**
     * @var string
     */
    #[Validate('required|date')]
    public $start_date = '';

    /**
     * @var string
     */
    #[Validate('required|date')]
    public $end_date = '';
}
