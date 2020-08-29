<?php

namespace EKvedaras\PHPEnum;

use Illuminate\Support\Collection;

/**
 * Class IlluminateCollectionEnum
 * @package EKvedaras\PHPEnum
 * @method static Collection|static[] enum()
 */
abstract class IlluminateCollectionEnum extends Enum
{
    use ArrayAccessibleStorage;

    /**
     * @return Collection
     */
    protected static function getNewStorage()
    {
        return new Collection();
    }

    /**
     * @return Collection|string[]
     */
    public static function options()
    {
        return static::enum()->map(function (self $enum) {
            return $enum->name();
        });
    }

    /**
     * @return Collection|int[]|string[]
     */
    public static function keys()
    {
        return static::enum()->keys();
    }
}
