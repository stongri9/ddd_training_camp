<?php

namespace App\Livewire\Forms\Inquiry;

use Livewire\Attributes\Validate;
use Livewire\Form;

class CreateForm extends Form
{
    /**
     * @var string
     */
    #[Validate('required')]
    public $last_name = '';

    /**
     * @var string
     */
    #[Validate('required')]
    public $first_name = '';

    /**
     * @var string
     */
    #[Validate('required')]
    public $tel = '';

    /**
     * @var string
     */
    #[Validate('required')]
    public $zip_code = '';

    /**
     * @var string
     */
    #[Validate('required')]
    public $address = '';

    /**
     * @var string
     */
    #[Validate('required')]
    public $content = '';
}
