<?php

namespace App\UseCases\Inquiry;

class UpdateUseCaseDto
{
    private function __construct(
        public readonly int $id,
        public readonly string $last_name,
        public readonly string $first_name,
        public readonly string $tel,
        public readonly string $zip_code,
        public readonly string $address,
        public readonly string $content,
    ) {}

    public static function create(
        int $id,
        string $last_name,
        string $first_name,
        string $tel,
        string $zip_code,
        string $address,
        string $content,
    ): self {
        return new UpdateUseCaseDto(
            $id,
            $last_name,
            $first_name,
            $tel,
            $zip_code,
            $address,
            $content,
        );
    }
}
