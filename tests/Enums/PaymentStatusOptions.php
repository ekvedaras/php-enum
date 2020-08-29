<?php

namespace Tests\Enums;

use Tests\EnumTest;

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
            EnumTest::PAYMENT_STATUS_IDS[EnumTest::PAYMENT_STATUS_PENDING],
            EnumTest::PAYMENT_STATUS_NAMES[EnumTest::PAYMENT_STATUS_PENDING],
            EnumTest::PAYMENT_STATUS_META[EnumTest::PAYMENT_STATUS_PENDING]
        );
    }

    /**
     * @return static
     */
    final public static function completed(): self
    {
        return static::get(
            EnumTest::PAYMENT_STATUS_IDS[EnumTest::PAYMENT_STATUS_COMPLETED],
            EnumTest::PAYMENT_STATUS_NAMES[EnumTest::PAYMENT_STATUS_COMPLETED],
            EnumTest::PAYMENT_STATUS_META[EnumTest::PAYMENT_STATUS_COMPLETED]
        );
    }

    /**
     * @return static
     */
    final public static function failed(): self
    {
        return static::get(
            EnumTest::PAYMENT_STATUS_IDS[EnumTest::PAYMENT_STATUS_FAILED],
            EnumTest::PAYMENT_STATUS_NAMES[EnumTest::PAYMENT_STATUS_FAILED],
            EnumTest::PAYMENT_STATUS_META[EnumTest::PAYMENT_STATUS_FAILED]
        );
    }

    public static function notPartOfEnumStatic()
    {
    }

    public function notPartOfEnum()
    {
    }
}
