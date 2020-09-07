<?php

namespace EKvedaras\PHPEnum\Storage;

/**
 * Trait GenericArrayAccessibleObjectStorage
 * @package EKvedaras\PHPEnum\Storage
 */
trait GenericArrayAccessibleObjectStorage
{
    use GenericArrayAccessibleStorage;

    /**
     * @return string[]
     */
    public static function options()
    {
        return static::enum()->map(function (self $enum) {
            return $enum->name();
        });
    }

    /**
     * @return int[]|string[]
     */
    public static function keys()
    {
        return static::enum()->keys();
    }

    /**
     * @inheritDoc
     */
    public static function keyString(string $glue = ',')
    {
        return static::keys()->implode($glue);
    }
}
