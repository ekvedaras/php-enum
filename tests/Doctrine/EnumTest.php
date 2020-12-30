<?php

namespace Tests\Doctrine;

use Doctrine\Common\Collections\ArrayCollection;
use Tests\BaseEnumTest;
use Tests\Enums\PaymentStatusDoctrineEnum;
use Tests\TestCase;

/**
 * Class EnumTest
 * @package Tests\Doctrine
 */
class EnumTest extends TestCase
{
    /** @test */
    public function it_returns_doctrine_storage()
    {
        $this->assertInstanceOf(ArrayCollection::class, PaymentStatusDoctrineEnum::enum());
        $this->assertInstanceOf(ArrayCollection::class, PaymentStatusDoctrineEnum::options());
        $this->assertInstanceOf(ArrayCollection::class, PaymentStatusDoctrineEnum::keys());
    }

    /** @test */
    public function it_fetches_keys()
    {
        $this->assertEquals(array_values(BaseEnumTest::PAYMENT_STATUS_IDS), PaymentStatusDoctrineEnum::keys()->toArray());
    }
}
