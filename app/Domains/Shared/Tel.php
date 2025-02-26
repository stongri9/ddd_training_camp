<?php

namespace App\Domains\Shared;

class Tel
{
    /**
     * @param string $value
     */
    private function __construct(
        public readonly string $value,
    ) {}

    /**
     * @param string $tel
     * @throws \InvalidArgumentException
     * @return Tel
     */
    public static function create(string $tel): self
    {
        if (! preg_match('/^0\d{9,10}$/', $tel)) {
            throw new \InvalidArgumentException('電話番号の形式が不正です。');
        }

        return new self($tel);
    }
}
