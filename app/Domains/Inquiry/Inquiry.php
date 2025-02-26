<?php

namespace App\Domains\Inquiry;

use App\Domains\Shared\Tel;
use App\Domains\Shared\ZipCode;

class Inquiry
{
    /**
     * @param  string  $last_name
     * @param  string  $first_name
     * @param  \App\Domains\Shared\Tel  $tel
     * @param  \App\Domains\Shared\ZipCode  $zip_code
     * @param  string  $address
     * @param  string  $content
     */
    private function __construct(
        public readonly ?int $id,
        public private(set) string $last_name,
        public private(set) string $first_name,
        public private(set) Tel $tel,
        public private(set) ZipCode $zip_code,
        public private(set) string $address,
        public private(set) string $content,
    ) {}

    /**
     * @param string $last_name
     * @param string $first_name
     * @param string $tel
     * @param string $zip_code
     * @param string $address
     * @param string $content
     * @return Inquiry
     */
    public static function create(
        string $last_name,
        string $first_name,
        string $tel,
        string $zip_code,
        string $address,
        string $content,
    ): self {
        return new self(
            null,
            $last_name,
            $first_name,
            Tel::create($tel),
            ZipCode::create($zip_code),
            $address,
            $content,
        );
    }

    /**
     * @param int $id
     * @param string $last_name
     * @param string $first_name
     * @param string $tel
     * @param string $zip_code
     * @param string $address
     * @param string $content
     * @return Inquiry
     */
    public static function reconstract(
        int $id,
        string $last_name,
        string $first_name,
        string $tel,
        string $zip_code,
        string $address,
        string $content,
    ): self {
        return new self(
            $id,
            $last_name,
            $first_name,
            Tel::create($tel),
            ZipCode::create($zip_code),
            $address,
            $content,
        );
    }

    /**
     * @param string $last_name
     * @param string $first_name
     * @param string $tel
     * @param string $zip_code
     * @param string $address
     * @param string $content
     * @return void
     */
    public function update(
        string $last_name,
        string $first_name,
        string $tel,
        string $zip_code,
        string $address,
        string $content,
    ): void {
        $this->last_name = $last_name;
        $this->first_name = $first_name;
        $this->tel = Tel::create($tel);
        $this->zip_code = ZipCode::create($zip_code);
        $this->address = $address;
        $this->content = $content;
    }

    /**
     * @return array{address: string, content: string, first_name: string, id: int|null, last_name: string, tel: string, zip_code: string}
     */
    public function convertParams(): array
    {
        return [
            'id' => $this->id,
            'last_name' => $this->last_name,
            'first_name' => $this->first_name,
            'tel' => $this->tel->value,
            'zip_code' => $this->zip_code->value,
            'address' => $this->address,
            'content' => $this->content,
        ];
    }
}
