<?php

namespace EKvedaras\PHPEnum\Arrayy;

use Arrayy\Arrayy;
use EKvedaras\PHPEnum\BaseEnum;
use EKvedaras\PHPEnum\Storage\GenericArrayAccessibleObjectStorage;

/**
 * Class Enum
 * @package EKvedaras\PHPEnum\Arrayy
 * @method static Arrayy|static[] enum()
 * @method static Arrayy|string[] options()
 * @method static Arrayy|int[]|string[] keys()
 */
class Enum extends BaseEnum
{
    use GenericArrayAccessibleObjectStorage;

    /**
     * @inheritDoc
     */
    protected static function getNewStorage()
    {
        return new Arrayy();
    }
}
