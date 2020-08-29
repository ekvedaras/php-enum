<?php

namespace Tests;

use Illuminate\Support\Collection;
use PHPUnit\Framework\TestCase;
use Tests\Enums\PaymentStatusIlluminateCollectionEnum;

/**
 * Class IlluminateCollectionEnumTest
 * @package Tests
 */
class IlluminateCollectionEnumTest extends TestCase
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
        $this->assertEquals(array_values(EnumTest::PAYMENT_STATUS_IDS), PaymentStatusIlluminateCollectionEnum::keys()->toArray());
    }
}
