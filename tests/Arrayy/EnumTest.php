<?php

namespace Tests\Arrayy;

use Arrayy\Arrayy;
use Tests\BaseEnumTest;
use Tests\Enums\PaymentStatusArrayyEnum;
use Tests\TestCase;

/**
 * Class EnumTest
 * @package Tests\Arrayy
 */
class EnumTest extends TestCase
{
    /** @test */
    public function it_returns_arrayy_storage()
    {
        $this->assertInstanceOf(Arrayy::class, PaymentStatusArrayyEnum::enum());
        $this->assertInstanceOf(Arrayy::class, PaymentStatusArrayyEnum::options());
        $this->assertInstanceOf(Arrayy::class, PaymentStatusArrayyEnum::keys());
    }

    /** @test */
    public function it_fetches_keys()
    {
        $this->assertEquals(array_values(BaseEnumTest::PAYMENT_STATUS_IDS), PaymentStatusArrayyEnum::keys()->toArray());
    }
}
