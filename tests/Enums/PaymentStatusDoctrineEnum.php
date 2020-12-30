<?php

namespace Tests\Enums;

use EKvedaras\PHPEnum\Doctrine\Enum;

/**
 * Class PaymentStatusDoctrineEnum
 * @package Tests\Enums
 */
class PaymentStatusDoctrineEnum extends Enum
{
    use PaymentStatusOptions;
}
