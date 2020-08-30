<?php

namespace Tests\Enums;

use Tests\BaseEnumTest;

/**
 * Trait PaymentStatusOptions
 * @package Tests\Enums
 */
trait PaymentStatusOptions
{
    /**
     * @return static
     */
    final public static function pending(): self
    {
        return static::get(
            BaseEnumTest::PAYMENT_STATUS_IDS[BaseEnumTest::PAYMENT_STATUS_PENDING],
            BaseEnumTest::PAYMENT_STATUS_NAMES[BaseEnumTest::PAYMENT_STATUS_PENDING],
            BaseEnumTest::PAYMENT_STATUS_META[BaseEnumTest::PAYMENT_STATUS_PENDING]
        );
    }

    /**
     * @return static
     */
    final public static function completed(): self
    {
        return static::get(
            BaseEnumTest::PAYMENT_STATUS_IDS[BaseEnumTest::PAYMENT_STATUS_COMPLETED],
            BaseEnumTest::PAYMENT_STATUS_NAMES[BaseEnumTest::PAYMENT_STATUS_COMPLETED],
            BaseEnumTest::PAYMENT_STATUS_META[BaseEnumTest::PAYMENT_STATUS_COMPLETED]
        );
    }

    /**
     * @return static
     */
    final public static function failed(): self
    {
        return static::get(
            BaseEnumTest::PAYMENT_STATUS_IDS[BaseEnumTest::PAYMENT_STATUS_FAILED],
            BaseEnumTest::PAYMENT_STATUS_NAMES[BaseEnumTest::PAYMENT_STATUS_FAILED],
            BaseEnumTest::PAYMENT_STATUS_META[BaseEnumTest::PAYMENT_STATUS_FAILED]
        );
    }

    public static function notPartOfEnumStatic()
    {
    }

    public function notPartOfEnum()
    {
    }
}
