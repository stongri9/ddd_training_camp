<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DayOffRequestDayFactory extends Factory
{
    public function definition(): array
    {
        return [
            'day_off_request_id' => 1,
            'date' => fake()->date('Y-m-d'),
        ];
    }
}
