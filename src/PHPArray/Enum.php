<?php

namespace EKvedaras\PHPEnum\PHPArray;

use EKvedaras\PHPEnum\BaseEnum;
use EKvedaras\PHPEnum\Storage\ArrayAccessibleStorage;

/**
 * Class Enum
 * @package EKvedaras\PHPEnum\PHPArray
 */
abstract class Enum extends BaseEnum
{
    use ArrayAccessibleStorage;

    /**
     * @inheritDoc
     */
    protected static function getNewStorage()
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    protected static function &getFromStorage(&$storage, $key)
    {
        return $storage[$key];
    }
}
