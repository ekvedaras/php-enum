<?php

namespace Tests\PHPArray;

use Tests\Enums\PaymentStatusArrayEnum;
use Tests\TestCase;

/**
 * Class EnumTest
 * @package Tests\PHPArray
 */
class EnumTest extends TestCase
{
    /** @test */
    public function it_returns_array_storage()
    {
        $this->assertIsArray(PaymentStatusArrayEnum::enum());
        $this->assertIsArray(PaymentStatusArrayEnum::options());
        $this->assertIsArray(PaymentStatusArrayEnum::keys());
    }
}
