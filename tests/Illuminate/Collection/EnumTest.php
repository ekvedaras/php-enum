<?php

namespace Tests\Illuminate\Collection;

use Illuminate\Support\Collection;
use Tests\BaseEnumTest;
use Tests\Enums\PaymentStatusIlluminateCollectionEnum;
use Tests\TestCase;

/**
 * Class EnumTest
 * @package Tests\Illuminate\Collection
 */
class EnumTest extends TestCase
{
    /** @test */
    public function it_returns_illuminate_collection_storage()
    {
        $this->assertInstanceOf(Collection::class, PaymentStatusIlluminateCollectionEnum::enum());
        $this->assertInstanceOf(Collection::class, PaymentStatusIlluminateCollectionEnum::options());
        $this->assertInstanceOf(Collection::class, PaymentStatusIlluminateCollectionEnum::keys());
    }

    /** @test */
    public function it_fetches_keys()
    {
        $this->assertEquals(array_values(BaseEnumTest::PAYMENT_STATUS_IDS), PaymentStatusIlluminateCollectionEnum::keys()->toArray());
    }
}
