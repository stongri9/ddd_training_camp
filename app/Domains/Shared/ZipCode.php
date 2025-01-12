<?php 

namespace App\Domains\Shared;

class ZipCode {
    /**
     * @param string $value
     * @throws \InvalidArgumentException
     */
    private function __construct(
        public readonly string $value
    ) {
    }

    /**
     * @param string $zipCode
     * @return \App\Domains\Shared\ZipCode
     */
    public static function create(string $zipCode): self
    {
        if (!preg_match('/^\d{7}$/', $zipCode)) {
            throw new \InvalidArgumentException('郵便番号の値が不正です。');
        }
        return new self($zipCode);
    }
}