<?php

namespace App\Livewire\Forms\Inquiry;

use App\Models\Inquiry;
use Livewire\Attributes\Validate;
use Livewire\Form;

class UpdateForm extends Form
{
    /**
     * @var string
     */
    #[Validate('required', 'int')]
    public $id = '';

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

    public function setInquiry(Inquiry $inquiry): void
    {
        $this->id = $inquiry->id;
        $this->last_name = $inquiry->last_name;
        $this->first_name = $inquiry->first_name;
        $this->tel = $inquiry->tel;
        $this->zip_code = $inquiry->zip_code;
        $this->address = $inquiry->address;
        $this->content = $inquiry->content;
    }
}
