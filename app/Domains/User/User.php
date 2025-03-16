<?php

namespace app\Domains\User;

class User
{
    /**
     * @param  int|null  $id
     */
    private function __construct(
        public readonly ?int $id = null,
    ) {}
}
