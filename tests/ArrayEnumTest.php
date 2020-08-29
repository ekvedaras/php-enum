<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Tests\Enums\PaymentStatusArrayEnum;

/**
 * Class ArrayEnumTest
 * @package Tests
 */
class ArrayEnumTest extends TestCase
{
    /** @test */
    public function it_returns_array_storage()
    {
        $this->assertIsArray(PaymentStatusArrayEnum::enum());
        $this->assertIsArray(PaymentStatusArrayEnum::options());
        $this->assertIsArray(PaymentStatusArrayEnum::keys());
    }
}
