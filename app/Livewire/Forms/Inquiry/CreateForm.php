<?php

namespace App\Livewire\Forms\Inquiry;

use Livewire\Attributes\Validate;
use Livewire\Form;

class CreateForm extends Form
{
    #[Validate('required')]
    public $last_name = '';

    #[Validate('required')]
    public $first_name = '';

    #[Validate('required')]
    public $tel = '';

    #[Validate('required')]
    public $zip_code = '';

    #[Validate('required')]
    public $address = '';

    #[Validate('required')]
    public $content = '';
}
