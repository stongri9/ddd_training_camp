<?php 

namespace App\Domains\Inquiry;

use App\Attributes\Getter;
use App\Domains\DomainEntity;
use App\Domains\Shared\Tel;
use App\Domains\Shared\ZipCode;

class Inquiry extends DomainEntity {
    /**
     * @param int|null $id
     * @param string $last_name
     * @param string $first_name
     * @param \App\Domains\Shared\Tel $tel
     * @param \App\Domains\Shared\ZipCode $zip_code
     * @param string $address
     * @param string $content
     */
    private function __construct(
        #[Getter] private int|null $id = null,
        #[Getter] private string $last_name,
        #[Getter] private string $first_name,
        #[Getter] private Tel $tel,
        #[Getter] private ZipCode $zip_code,
        #[Getter] private string $address,
        #[Getter] private string $content,
    ) {
    }

    /**
     * @param string $last_name
     * @param string $first_name
     * @param string $tel
     * @param string $zip_code
     * @param string $address
     * @param string $content
     * @return \App\Domains\Inquiry\Inquiry
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
     * @return \App\Domains\Inquiry\Inquiry
     */
    public static function recontract(
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
    ): void
    {
        $this->last_name = $last_name;
        $this->first_name = $first_name;
        $this->tel = Tel::create($tel);
        $this->zip_code = ZipCode::create($zip_code);
        $this->address = $address;
        $this->content = $content;
    }

    /**
     * @return array
     */
    public function convertParams():array {
        return [
            'last_name' => $this->last_name,
            'first_name' => $this->first_name,
            'tel' => $this->tel->value,
            'zip_code' => $this->zip_code->value,
            'address' => $this->address,
            'content' => $this->content,
        ];
    }
}