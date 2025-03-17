<?php

namespace App\Livewire\Forms\Shift;

// use App\Models\Shift;
use Livewire\Attributes\Validate;
use Livewire\Form;

class ApplyForm extends Form
{
    /**
     * @var int
     */
    #[Validate('required|int')]
    public $id;

    /**
     * @var string[]
     */
    #[Validate('required|array')]
    public $day_shift_users = [];

    /**
     * @var string[]
     */
    #[Validate('required|array')]
    public $late_shift_users = [];

    /**
     * @var string[]
     */
    #[Validate('required|array')]
    public $night_shift_users = [];

    /**
     * @var string
     */
    #[Validate('required')]
    public $comment = '';

    public function setShift(
        // Shift $shift
    ): void {
        // $this->id = $shift->id;
        // $this->day_shift_users = $shift->day_shift_users;
        // $this->late_shift_users = $shift->late_shift_users;
        // $this->night_shift_users = $shift->night_shift_users;
        $this->id = 1;
        $this->day_shift_users = [];
        $this->late_shift_users = [];
        $this->night_shift_users = [];
        $this->comment = '';
    }
}
