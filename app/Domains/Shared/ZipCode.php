<?php

namespace App\Domains\Shared;

class ZipCode
{
    /**
     * @throws \InvalidArgumentException
     */
    private function __construct(
        public readonly string $value
    ) {}

    public static function create(string $zipCode): self
    {
        if (! preg_match('/^\d{7}$/', $zipCode)) {
            throw new \InvalidArgumentException('郵便番号の値が不正です。');
        }

        return new self($zipCode);
    }
}
