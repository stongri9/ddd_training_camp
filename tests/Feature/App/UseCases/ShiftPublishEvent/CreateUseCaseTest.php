<?php

namespace Tests\Feature\App\UseCases\ShiftPublishEvent;

use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateUseCaseTest extends TestCase
{
  use RefreshDatabase;

  public function setUp(): void
  {
    parent::setUp();
  }

  #[Test]
  public function シフトを公開すると、公開イベントが作成される(): bool
  {
    // TODO: シフト割り振りモデルを取り込んだら、テストを書く
    return true;
  }
}