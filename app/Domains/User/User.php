<?php

namespace app\Domains\User;

class User
{
    private function __construct(
        public readonly ?int $id = null,
    ) {}
}
