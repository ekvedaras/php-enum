<?php

namespace EKvedaras\PHPEnum\Doctrine;

use Doctrine\Common\Collections\ArrayCollection;
use EKvedaras\PHPEnum\BaseEnum;
use EKvedaras\PHPEnum\Storage\GenericArrayAccessibleObjectStorage;

/**
 * Class Enum
 * @package EKvedaras\PHPEnum\Doctrine
 * @method static ArrayCollection|static[] enum()
 * @method static ArrayCollection|string[] options()
 */
class Enum extends BaseEnum
{
    use GenericArrayAccessibleObjectStorage;

    /**
     * @inheritDoc
     */
    protected static function getNewStorage()
    {
        return new ArrayCollection();
    }

    /**
     * @return ArrayCollection|int[]|string[]
     */
    public static function keys()
    {
        return new ArrayCollection(static::enum()->getKeys());
    }

    /**
     * @inheritDoc
     */
    public static function keyString(string $glue = ',')
    {
        return implode($glue, static::keys()->toArray());
    }
}
