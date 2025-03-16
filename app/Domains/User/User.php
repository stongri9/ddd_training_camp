<?php

namespace app\Domains\User;

class User
{
    /**
     * @param  Role  $role
     */
    private function __construct(
        public readonly ?int $id,
        public private(set) Role $role,
    ) {}

    /**
     * @param  string  $role
     */
    public static function create(string $role): self
    {
        $role = Role::tryFrom($role);
        if (is_null($role)) {
            throw new \InvalidArgumentException('不正なロールです。');
        }

        return new self(
            null,
            $role,
        );
    }

    /**
     * @return array{id: int|null, role: string}
     */
    public function convertParams(): array
    {
        return [
            'id' => $this->id,
            'role' => $this->role->value,
        ];
    }

    /**
     * @param  Role  $role
     */
    public static function reconstruct(
        int $id,
        Role $role,
    ): self {
        return new self($id, $role);
    }
}
