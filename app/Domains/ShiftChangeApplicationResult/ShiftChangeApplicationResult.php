<?php

namespace app\Domains\ShiftChangeApplicationResult;

class ShiftChangeApplicationResult
{
    /**
     * @param  int  $shift_change_application_id
     * @param  int  $confirm_user_id
     * @param  ResultType  $result_type
     * @param  string  $comment
     */
    private function __construct(
        public readonly ?int $id,
        public private(set) int $shift_change_application_id,
        public private(set) int $confirm_user_id,
        public private(set) ResultType $result_type,
        public private(set) string $comment,
    ) {}

    public static function create(int $shift_change_application_id, int $confirm_user_id, string $result_type, string $comment): self
    {
        $result_type = ResultType::tryFrom($result_type);
        if (is_null($result_type)) {
            throw new \InvalidArgumentException('不正な申請結果です。');
        }

        return new ShiftChangeApplicationResult(
            null,
            $shift_change_application_id,
            $confirm_user_id,
            $result_type,
            $comment,
        );
    }
}
