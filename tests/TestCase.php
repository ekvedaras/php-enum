<?php

namespace Tests;

use PHPUnit\Framework\TestCase as BaseTestCase;
use Tests\Enums\PaymentStatusArrayEnum;

/**
 * Class TestCase
 * @package Tests
 */
class TestCase extends BaseTestCase
{
    public static function setUpBeforeClass(): void
    {
        PaymentStatusArrayEnum::clearCache();
    }
}
