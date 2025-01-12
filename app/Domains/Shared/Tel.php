<?php 

namespace App\Domains\Shared;

class Tel {
    /**
     * @param string $value
     * @throws \InvalidArgumentException
     */
    private function __construct(
        public readonly string $value,
    ) {
        
        if (!preg_match('/^0\d{9,10}$/', $this->value)) {
            throw new \InvalidArgumentException('電話番号の形式が不正です。');
        }
    }

    /**
     * @param string $tel
     * @return \App\Domains\Shared\Tel
     */
    public static function create(string $tel): self 
    {
        return new self($tel);
    }
}