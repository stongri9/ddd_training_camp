<?php 

namespace App\Livewire\Forms\Inquiry;

use App\Models\Inquiry;
use Livewire\Attributes\Validate;
use Livewire\Form;

class UpdateInquiryForm extends Form 
{
    #[Validate('required', 'int')]
    public $id = '';
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