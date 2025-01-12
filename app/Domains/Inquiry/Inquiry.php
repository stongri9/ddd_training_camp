<?php 

namespace App\Domains\Inquiry;

use App\Domains\Shared\Tel;
use App\Domains\Shared\ZipCode;

class Inquiry {
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
        private int|null $id = null,
        private string $last_name,
        private string $first_name,
        private Tel $tel,
        private ZipCode $zip_code,
        private string $address,
        private string $content,
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
            last_name: $last_name,
            first_name:$first_name,
            tel: Tel::create($tel),
            zip_code:ZipCode::create($zip_code),
            address: $address,
            content: $content,
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
}