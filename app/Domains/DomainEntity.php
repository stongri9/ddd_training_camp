<?php 

namespace App\Domains;

use App\Attributes\Getter;
use ReflectionProperty;

class DomainEntity {
    public function __get(string $name): mixed
    {
        $reflectionProperty = new ReflectionProperty($this, $name);
        $reflectionAttributes = $reflectionProperty->getAttributes(Getter::class);
        if (!count($reflectionAttributes)) {
            return $this->{$name};
        }

        throw new \DomainException('アクセス不能なプロパティです。');
    }
}