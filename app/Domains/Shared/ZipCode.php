<?php 

namespace App\Domains\Shared;

class ZipCode {
    /**
     * @param string $value
     * @throws \InvalidArgumentException
     */
    private function __construct(
        private readonly string $value
    ) {
        if (preg_match('/[0-9]{7}/', $this->value)) {
            throw new \InvalidArgumentException('郵便番号の値が不正です。');
        }
    }

    /**
     * @param string $zipCode
     * @return \App\Domains\Shared\ZipCode
     */
    public static function create(string $zipCode): self
    {
        return new self($zipCode);
    }
}