<?php

namespace Tests;

use EKvedaras\PHPEnum\BaseEnum;
use OutOfBoundsException;
use RuntimeException;
use Tests\Enums\PaymentStatusArrayEnum;
use Tests\Enums\PaymentStatusArrayyEnum;
use Tests\Enums\PaymentStatusDoctrineEnum;
use Tests\Enums\PaymentStatusIlluminateCollectionEnum;
use Tests\Enums\PaymentStatusOptions;

/**
 * Class EnumTest
 * @package Tests
 */
class BaseEnumTest extends TestCase
{
    public const PAYMENT_STATUS_PENDING   = 'pending';
    public const PAYMENT_STATUS_COMPLETED = 'completed';
    public const PAYMENT_STATUS_FAILED    = 'failed';

    public const PAYMENT_STATUS_IDS = [
        self::PAYMENT_STATUS_PENDING   => 'pending',
        self::PAYMENT_STATUS_COMPLETED => 'completed',
        self::PAYMENT_STATUS_FAILED    => 0,
    ];

    public const PAYMENT_STATUS_NAMES = [
        self::PAYMENT_STATUS_PENDING   => 'Payment is pending',
        self::PAYMENT_STATUS_COMPLETED => 'Payment is completed',
        self::PAYMENT_STATUS_FAILED    => null,
    ];

    public const PAYMENT_STATUS_META = [
        self::PAYMENT_STATUS_PENDING   => 'meta-as-string',
        self::PAYMENT_STATUS_COMPLETED => ['meta-as-array'],
        self::PAYMENT_STATUS_FAILED    => null,
    ];

    /**
     * @return string[]
     */
    public function enums(): array
    {
        return [
            'array-storage'      => [PaymentStatusArrayEnum::class],
            'collection-storage' => [PaymentStatusIlluminateCollectionEnum::class],
            'arrayy'             => [PaymentStatusArrayyEnum::class],
            'doctrine'           => [PaymentStatusDoctrineEnum::class],
        ];
    }

    /**
     * @test
     * @dataProvider enums
     * @param BaseEnum|PaymentStatusOptions|string $enum
     */
    public function it_does_not_crash_when_calling_from_for_yet_unregistered_id(string $enum)
    {
        $pendingKey  = self::PAYMENT_STATUS_PENDING;
        $completedId = self::PAYMENT_STATUS_IDS[self::PAYMENT_STATUS_COMPLETED];

        $this->assertInstanceOf($enum, $enum::$pendingKey());
        $this->assertInstanceOf($enum, $enum::from($completedId));
    }

    /**
     * @test
     * @dataProvider enums
     * @runInSeparateProcess
     * @param BaseEnum|PaymentStatusOptions|string $enum
     */
    public function it_does_not_crash_when_calling_enum_first(string $enum)
    {
        $this->assertNotEmpty($enum::enum());
    }

    /**
     * @test
     * @dataProvider enums
     * @param BaseEnum|PaymentStatusOptions|string $enum
     */
    public function it_fetches_enum_list(string $enum)
    {
        $list = $enum::enum();

        $this->assertCount(count(self::PAYMENT_STATUS_IDS), $list);

        foreach (self::PAYMENT_STATUS_IDS as $id) {
            $this->assertArrayHasKey($id, $list);
            $this->assertInstanceOf($enum, $list[$id]);
        }
    }

    /**
     * @test
     * @dataProvider enums
     * @param BaseEnum|PaymentStatusOptions|string $enum
     */
    public function it_fetches_option_list(string $enum)
    {
        $list = $enum::options();

        $this->assertCount(count(self::PAYMENT_STATUS_IDS), $list);

        foreach (self::PAYMENT_STATUS_NAMES as $key => $name) {
            $id = self::PAYMENT_STATUS_IDS[$key];

            $this->assertArrayHasKey($id, $list);
            $this->assertIsString($list[$id]);
            $this->assertEquals($name ?? $id, $list[$id]);
        }
    }

    /**
     * @test
     * @dataProvider enums
     * @param BaseEnum|PaymentStatusOptions|string $enum
     */
    public function it_fetches_key_list(string $enum)
    {
        $list       = $enum::keys();
        $listString = $enum::keyString($glue = ';');

        $this->assertCount(count(self::PAYMENT_STATUS_IDS), $list);

        foreach (self::PAYMENT_STATUS_IDS as $key => $id) {
            $this->assertContains($id, $list);
            $this->assertStringContainsString((string)$id, $listString);
        }
    }

    /**
     * @test
     * @dataProvider enums
     * @param BaseEnum|PaymentStatusOptions|string $enum
     */
    public function it_fetches_enum_as_json(string $enum)
    {
        $this->assertJson($enum::json());
        $this->assertEquals(json_encode($enum::enum()), $enum::json());
    }

    /**
     * @test
     * @dataProvider enums
     * @param BaseEnum|PaymentStatusOptions|string $enum
     */
    public function it_fetches_options_as_json(string $enum)
    {
        $this->assertJson($enum::jsonOptions());
        $this->assertEquals(json_encode($enum::options()), $enum::jsonOptions());
    }

    /**
     * @test
     * @dataProvider enums
     * @param BaseEnum|PaymentStatusOptions|string $enum
     */
    public function it_retrieves_from_id_and_returns_correct_values(string $enum)
    {
        foreach (self::PAYMENT_STATUS_NAMES as $key => $name) {
            $id         = self::PAYMENT_STATUS_IDS[$key];
            $enumOption = $enum::from($id);

            $this->assertEquals($id, $enumOption->id());
            $this->assertEquals($name ?? $id, $enumOption->name());
            $this->assertEquals(self::PAYMENT_STATUS_META[$key] ?? null, $enumOption->meta());
        }
    }

    /**
     * @test
     * @dataProvider enums
     * @param BaseEnum|PaymentStatusOptions|string $enum
     */
    public function it_retrieves_from_meta_and_returns_correct_values(string $enum)
    {
        foreach (self::PAYMENT_STATUS_META as $key => $meta) {
            $id         = self::PAYMENT_STATUS_IDS[$key];
            $enumOption = $enum::fromMeta($meta);

            $this->assertEquals($id, $enumOption->id());
            $this->assertEquals(self::PAYMENT_STATUS_NAMES[$key] ?? $id, $enumOption->name());
            $this->assertEquals($meta, $enumOption->meta());
        }
    }

    /**
     * @test
     * @runInSeparateProcess
     * @dataProvider enums
     * @param BaseEnum|PaymentStatusOptions|string $enum
     */
    public function it_retrieves_by_calling_a_method_and_returns_correct_values(string $enum)
    {
        foreach (self::PAYMENT_STATUS_NAMES as $key => $name) {
            $id         = self::PAYMENT_STATUS_IDS[$key];
            $enumOption = $enum::$key();

            $this->assertEquals($id, $enumOption->id());
            $this->assertEquals($name ?? $id, $enumOption->name());
            $this->assertEquals(self::PAYMENT_STATUS_META[$key] ?? null, $enumOption->meta());
        }
    }

    /**
     * @test
     * @dataProvider enums
     * @param BaseEnum|PaymentStatusOptions|string $enum
     */
    public function it_creates_only_one_instance_of_each_option(string $enum)
    {
        $all = $enum::enum();

        foreach (self::PAYMENT_STATUS_IDS as $key => $id) {
            $this->assertSame($enum::$key(), $enum::from($id));
            $this->assertSame($all[$id], $enum::from($id));
            $this->assertSame($all[$id], $enum::$key());
        }
    }

    /**
     * @test
     * @dataProvider enums
     * @param BaseEnum|PaymentStatusOptions|string $enum
     */
    public function it_cannot_be_serialized(string $enum)
    {
        $this->expectExceptionObject(
            new RuntimeException("PHP serialization of EnumerableType is not supported. [{$enum}]")
        );

        serialize($enum::from(self::PAYMENT_STATUS_COMPLETED));
    }

    /**
     * @test
     * @dataProvider enums
     * @param BaseEnum|PaymentStatusOptions|string $enum
     */
    public function it_throws_an_exception_for_unknown_id(string $enum)
    {
        $id = rand(1, 10);
        $this->expectExceptionObject(
            new OutOfBoundsException("{$enum}::from({$id}): given id doesn't exist on this enumerable type.")
        );

        $enum::from($id);
    }

    /**
     * @test
     * @dataProvider enums
     * @param BaseEnum|PaymentStatusOptions|string $enum
     */
    public function it_throws_an_exception_for_unknown_meta(string $enum)
    {
        $meta = rand(1, 10);
        $this->expectExceptionObject(
            new OutOfBoundsException("{$enum}::fromMeta({$meta}): given meta doesn't exist on this enumerable type.")
        );

        $enum::fromMeta($meta);
    }

    /**
     * @test
     * @dataProvider enums
     * @param BaseEnum|PaymentStatusOptions|string $enum
     */
    public function it_casts_to_string_as_id(string $enum)
    {
        foreach (self::PAYMENT_STATUS_IDS as $id) {
            $this->assertSame((string)$id, (string)$enum::from($id));
        }
    }

    /**
     * @test
     * @dataProvider enums
     * @param BaseEnum|PaymentStatusOptions|string $enum
     */
    public function it_can_be_json_serialized(string $enum)
    {
        foreach ($enum::enum() as $item) {
            $this->assertEquals(
                json_encode(array_filter([
                    'id'   => $item->id(),
                    'name' => $item->name(),
                    'meta' => $item->meta(),
                ])),
                json_encode($item)
            );
        }
    }

    /**
     * @test
     * @dataProvider enums
     * @param BaseEnum|PaymentStatusOptions|string $enum
     */
    public function it_can_set_state(string $enum)
    {
        foreach ($enum::enum() as $item) {
            eval('$restored = ' . var_export($item, true) . ';');

            $this->assertEquals($restored, $item);
        }
    }
}
