<?php

namespace Tests\Unit\Domains\Inquiry;

use app\Domains\Inquiry\Inquiry;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class InquiryTest extends TestCase
{
    private string $lastName = '山田';

    private string $firstName = '太郎';

    private string $tel = '09012345678';

    private string $zipCode = '1234567';

    private string $address = '東京都渋谷区';

    private string $content = 'お問い合わせ内容';

    public function test_create_inquiry(): void
    {
        $inquiry = Inquiry::create(
            $this->lastName,
            $this->firstName,
            $this->tel,
            $this->zipCode,
            $this->address,
            $this->content,
        );

        $params = $inquiry->convertParams();
        $this->assertNull($params['id']);
        $this->assertSame($this->lastName, $params['last_name']);
        $this->assertSame($this->firstName, $params['first_name']);
        $this->assertSame($this->tel, $params['tel']);
        $this->assertSame($this->zipCode, $params['zip_code']);
        $this->assertSame($this->address, $params['address']);
        $this->assertSame($this->content, $params['content']);
    }

    public function test_reconstract_inquiry(): void
    {
        $id = 1;
        $inquiry = Inquiry::reconstract(
            $id,
            $this->lastName,
            $this->firstName,
            $this->tel,
            $this->zipCode,
            $this->address,
            $this->content,
        );

        $params = $inquiry->convertParams();
        $this->assertSame($id, $params['id']);
        $this->assertSame($this->lastName, $params['last_name']);
        $this->assertSame($this->firstName, $params['first_name']);
        $this->assertSame($this->tel, $params['tel']);
        $this->assertSame($this->zipCode, $params['zip_code']);
        $this->assertSame($this->address, $params['address']);
        $this->assertSame($this->content, $params['content']);
    }

    public function test_update_inquiry(): void
    {
        $inquiry = Inquiry::create(
            $this->lastName,
            $this->firstName,
            $this->tel,
            $this->zipCode,
            $this->address,
            $this->content,
        );

        $newLastName = '鈴木';
        $newFirstName = '花子';
        $newTel = '08098765432';
        $newZipCode = '9876543';
        $newAddress = '大阪府大阪市';
        $newContent = '更新後のお問い合わせ内容';

        $inquiry->update(
            $newLastName,
            $newFirstName,
            $newTel,
            $newZipCode,
            $newAddress,
            $newContent,
        );

        $params = $inquiry->convertParams();
        $this->assertSame($newLastName, $params['last_name']);
        $this->assertSame($newFirstName, $params['first_name']);
        $this->assertSame($newTel, $params['tel']);
        $this->assertSame($newZipCode, $params['zip_code']);
        $this->assertSame($newAddress, $params['address']);
        $this->assertSame($newContent, $params['content']);
    }

    #[DataProvider('invalidTelProvider')]
    public function test_create_inquiry_with_invalid_tel(string $invalidTel): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('電話番号の形式が不正です。');

        Inquiry::create(
            $this->lastName,
            $this->firstName,
            $invalidTel,
            $this->zipCode,
            $this->address,
            $this->content,
        );
    }

    /**
     * @return array<string, array{string}>
     */
    public static function invalidTelProvider(): array
    {
        return [
            '電話番号が数字以外を含む' => ['090-1234-5678'],
            '電話番号が短すぎる' => ['090123456'],
            '電話番号が長すぎる' => ['090123456789'],
            '電話番号が0以外で始まる' => ['19012345678'],
            '電話番号が空文字' => [''],
        ];
    }

    #[DataProvider('invalidZipCodeProvider')]
    public function test_create_inquiry_with_invalid_zip_code(string $invalidZipCode): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('郵便番号の値が不正です。');

        Inquiry::create(
            $this->lastName,
            $this->firstName,
            $this->tel,
            $invalidZipCode,
            $this->address,
            $this->content,
        );
    }

    /**
     * @return array<string, array{string}>
     */
    public static function invalidZipCodeProvider(): array
    {
        return [
            '郵便番号が数字以外を含む' => ['123-4567'],
            '郵便番号が短すぎる' => ['123456'],
            '郵便番号が長すぎる' => ['12345678'],
            '郵便番号が空文字' => [''],
        ];
    }
}
