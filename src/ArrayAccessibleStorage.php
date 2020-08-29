<?php

namespace EKvedaras\PHPEnum;

/**
 * Trait ArrayAccessibleStorage
 * @package EKvedaras\PHPEnum
 */
trait ArrayAccessibleStorage
{
    /**
     * @inheritDoc
     */
    protected static function existsInStorage($storage, $key): bool
    {
        return isset($storage[$key]);
    }

    /**
     * @inheritDoc
     */
    protected static function getFromStorage(&$storage, $key)
    {
        return $storage[$key];
    }

    /**
     * @inheritDoc
     */
    protected static function getFromStorageWhereFirst(&$storage, callable $condition)
    {
        foreach ($storage as $value) {
            if ($condition($value)) {
                return $value;
            }
        }

        return null;
    }

    /**
     * @inheritDoc
     */
    protected static function putToStorage(&$storage, $key, $value)
    {
        $storage[$key] = $value;
    }

    /**
     * @inheritDoc
     */
    public static function options()
    {
        return array_map(function (self $enum) {
            return $enum->name();
        }, static::enum());
    }

    /**
     * @inheritDoc
     */
    public static function keys()
    {
        return array_keys(static::enum());
    }

    /**
     * @inheritDoc
     */
    public static function json(): string
    {
        return (string)json_encode(static::enum());
    }

    /**
     * @inheritDoc
     */
    public static function jsonOptions(): string
    {
        return (string)json_encode(static::options());
    }

    /**
     * @inheritDoc
     */
    public static function exists($id): bool
    {
        return isset(static::enum()[$id]);
    }
}
