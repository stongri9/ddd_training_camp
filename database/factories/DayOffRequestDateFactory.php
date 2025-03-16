<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DayOffRequest>
 */
class DayOffRequestFactory extends Factory
{
    /**
     * 休み希望日のファクトリー
     *
     * @param int $id
     * @param int $dayOffRequestId
     * @param string $date
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => 1,
            'day_off_request_id' => 1,
            'date' => date('Y-m-d', strtotime('2025-01-01')),
        ];
    }
}
