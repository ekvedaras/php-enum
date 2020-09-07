<?php

namespace EKvedaras\PHPEnum\Illuminate\Collection;

use EKvedaras\PHPEnum\BaseEnum;
use EKvedaras\PHPEnum\Storage\GenericArrayAccessibleObjectStorage;
use Illuminate\Support\Collection;

/**
 * Class Enum
 * @package EKvedaras\PHPEnum\Illuminate\Collection
 * @method static Collection|static[] enum()
 * @method static Collection|string[] options()
 * @method static Collection|int[]|string[] keys()
 */
abstract class Enum extends BaseEnum
{
    use GenericArrayAccessibleObjectStorage;

    /**
     * @return Collection
     */
    protected static function getNewStorage()
    {
        return new Collection();
    }
}
