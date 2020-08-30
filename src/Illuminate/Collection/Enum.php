<?php

namespace EKvedaras\PHPEnum\Illuminate\Collection;

use EKvedaras\PHPEnum\BaseEnum;
use EKvedaras\PHPEnum\Storage\ArrayAccessibleStorage;
use Illuminate\Support\Collection;

/**
 * Class Enum
 * @package EKvedaras\PHPEnum\Illuminate\Collection
 * @method static Collection|static[] enum()
 */
abstract class Enum extends BaseEnum
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
