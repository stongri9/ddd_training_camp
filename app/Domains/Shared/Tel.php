<?php

namespace App\Domains\Shared;

class Tel
{
    private function __construct(
        public readonly string $value,
    ) {}

    /**
     * @throws \InvalidArgumentException
     */
    public static function create(string $tel): self
    {
        if (! preg_match('/^0\d{9,10}$/', $tel)) {
            throw new \InvalidArgumentException('電話番号の形式が不正です。');
        }

        return new self($tel);
    }
}
