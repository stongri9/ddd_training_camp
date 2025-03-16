<?php

namespace app\Domains\DayOffRequest;

class DayOffRequest
{
    /**
     * @param  int|null  $id
     * @param  int  $user_id
     * @param  DayOffRequestDateCollection  $dayOffRequestDateCollection
     */
    private function __construct(
        public readonly ?int $id,
        public readonly int $user_id,
        public readonly DayOffRequestDateCollection $dayOffRequestDateCollection,
    ) {}

    /**
     * @param  int  $user_id
     * @param  DayOffRequestDateCollection  $dayOffRequestDateCollection
     */
    public static function create(
        ?int $id,
        int $user_id,
        DayOffRequestDateCollection $dayOffRequestDateCollection
    ): self {
        return new self($id, $user_id, $dayOffRequestDateCollection);
    }

    /**
     * @param  int  $id
     * @param  int  $user_id
     * @param  DayOffRequestDateCollection  $dayOffRequestDateCollection
     */
    public static function reconstruct(
        int $id,
        int $user_id,
        DayOffRequestDateCollection $dayOffRequestDateCollection
    ): self {
        return new self($id, $user_id, $dayOffRequestDateCollection);
    }
}
