<?php

namespace EKvedaras\PHPEnum;

/**
 * Class ArrayEnum
 * @package EKvedaras\PHPEnum
 */
abstract class ArrayEnum extends Enum
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
