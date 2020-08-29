<?php

namespace EKvedaras\PHPEnum;

use JsonSerializable;
use OutOfBoundsException;
use ReflectionClass;
use ReflectionMethod;
use RuntimeException;

/**
 * Class EnumArray
 * @package EKvedaras\PHPEnum
 */
abstract class Enum implements JsonSerializable
{
    /** @var iterable|iterable[] */
    public static $cache;

    /** @var int|string */
    protected $id;

    /** @var string */
    protected $name;

    /** @var mixed|null */
    protected $meta;

    /**
     * @param string|int  $id
     * @param string|null $name
     * @param mixed|null  $meta
     */
    protected function __construct($id, string $name = null, $meta = null)
    {
        $this->id   = $id;
        $this->name = $name;
        $this->meta = $meta;
    }

    /**
     * Get new empty storage
     *
     * @return iterable
     */
    abstract protected static function getNewStorage();

    /**
     * Check if key exists in given storage
     *
     * @param iterable   $storage
     * @param string|int $key
     * @return bool
     */
    abstract protected static function existsInStorage($storage, $key): bool;

    /**
     * Fetch value from given storage
     *
     * @param iterable   $storage
     * @param string|int $key
     * @return mixed
     */
    abstract protected static function getFromStorage(&$storage, $key);

    /**
     * Fetch first value that matches the condition from given storage
     *
     * @param iterable $storage
     * @param callable $condition
     * @return mixed
     */
    abstract protected static function getFromStorageWhereFirst(&$storage, callable $condition);

    /**
     * Put value to given storage
     *
     * @param iterable   $storage
     * @param string|int $key
     * @param mixed      $value
     * @return void
     */
    abstract protected static function putToStorage(&$storage, $key, $value);

    /**
     * Get enum options as an associative array with keys as IDs and values as names
     *
     * @return string[]
     */
    abstract public static function options();

    /**
     * @return string[]|int[]
     */
    abstract public static function keys();

    /**
     * Get enum options with full data as JSON
     *
     * @return string
     */
    abstract public static function json(): string;

    /**
     * Get enum options like in options() method just as a JSON
     *
     * @return string
     */
    abstract public static function jsonOptions(): string;

    /**
     * Check if given ID exists among enum options
     *
     * @param string|int $id
     * @return bool
     */
    abstract public static function exists($id): bool;

    /**
     * @return int
     */
    private static function getClassKey(): int
    {
        return crc32(get_called_class()) & 0xFFFFFF;
    }

    /**
     * Static method which returns all available types
     *
     * @return static[]
     * @noinspection PhpDocMissingThrowsInspection
     */
    public static function enum()
    {
        $classKey = static::getClassKey();

        if (!isset(self::$cache)) {
            self::$cache = static::getNewStorage();
        }

        if (!static::existsInStorage(self::$cache, $classKey)) {
            $methods = static::getNewStorage();

            /** @noinspection PhpUnhandledExceptionInspection */
            foreach ((new ReflectionClass(get_called_class()))->getMethods(ReflectionMethod::IS_FINAL) as $method) {
                /** @var static $enum */
                $enum = $method->invoke(null);
                static::putToStorage($methods, $enum->id(), $enum);
            }

            static::putToStorage(self::$cache, $classKey, $methods);
        }

        return static::getFromStorage(self::$cache, $classKey);
    }

    /**
     * Static method which returns a type object from specified id
     *
     * @param string|int $id
     *
     * @throws OutOfBoundsException
     * @return static
     */
    public static function from($id): self
    {
        if (!static::exists($id)) {
            throw new OutOfBoundsException(sprintf("%s::from(%s): given id doesn't exist on this enumerable type.", get_called_class(), self::valueToString($id)));
        }

        $enum = static::enum();
        return static::getFromStorage($enum, $id);
    }

    /**
     * @param $meta
     * @throws OutOfBoundsException
     * @return static
     */
    public static function fromMeta($meta): self
    {
        $enum   = static::enum();
        $option = static::getFromStorageWhereFirst(
            $enum,
            function (self $option) use ($meta) {
                return $option->meta() === $meta;
            }
        );

        if (!$option) {
            throw new OutOfBoundsException(
                sprintf("%s::fromMeta(%s): given meta doesn't exist on this enumerable type.", get_called_class(), self::valueToString($meta))
            );
        }

        return $option;
    }

    /**
     * @param array $state
     * @return static
     */
    public static function __set_state(array $state): self
    {
        return static::get($state['id'], $state['name'], $state['meta']);
    }

    /**
     * @param string|int  $id
     * @param string|null $name
     * @param null        $meta
     * @noinspection PhpDocMissingThrowsInspection
     * @return static
     */
    protected static function get($id, string $name = null, $meta = null): self
    {
        if ($name === null) {
            $name = (string)$id;
        }

        $classKey = static::getClassKey();

        if (!isset(self::$cache)) {
            self::$cache = static::getNewStorage();
        }

        if (!static::existsInStorage(self::$cache, $classKey)) {
            static::putToStorage(self::$cache, $classKey, static::getNewStorage());
        }

        $instances = static::getFromStorage(self::$cache, $classKey);

        if (!static::existsInStorage($instances, $id)) {
            /** @noinspection PhpUnhandledExceptionInspection */
            $reflection = new ReflectionClass(get_called_class());
            $instance   = $reflection->newInstanceWithoutConstructor();

            $refConstructor = $reflection->getConstructor();
            $refConstructor->setAccessible(true);
            $refConstructor->invoke($instance, $id, $name, $meta);

            static::putToStorage($instances, $id, $instance);
        }

        return static::getFromStorage($instances, $id);
    }

    /**
     * @codeCoverageIgnore
     * @param mixed $value
     * @return string
     */
    private static function valueToString($value): string
    {
        if (is_null($value)) {
            return 'null';
        }

        if (is_bool($value)) {
            return $value ? 'true' : 'false';
        }

        return (string)$value;
    }

    /**
     * @return int|string
     */
    public function id()
    {
        return $this->id;
    }

    /**
     * @return mixed|null
     */
    public function meta()
    {
        return $this->meta;
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        return array_filter([
            'id'   => $this->id(),
            'name' => $this->name(),
            'meta' => $this->meta(),
        ]);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string)$this->id();
    }

    /**
     * Forbid PHP serialization
     */
    public function __sleep()
    {
        throw new RuntimeException('PHP serialization of EnumerableType is not supported. [' . get_called_class() . ']');
    }
}
