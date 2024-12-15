<?php

declare(strict_types=1);

namespace NickLai\LazyObject\Tests;

use NickLai\LazyObject\LazyObjectFactory;
use NickLai\LazyObject\LazyObjectHelper;
use NickLai\LazyObject\Tests\Fixtures\NormalClass;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(LazyObjectHelper::class)]
#[UsesClass(LazyObjectFactory::class)]
final class LazyObjectHelperTest extends TestCase
{
    #[Test]
    #[DataProvider('dataProvider')]
    public function createLazyObject($data): void
    {
        $lazyObject = LazyObjectHelper::createLazyObject(
            className: NormalClass::class,
            data: $data,
        );

        $this->runAsserts($data, $lazyObject);
    }

    #[Test]
    #[DataProvider('dataProvider')]
    public function createLazyObjectByArgumentsGetter($data): void
    {
        $lazyObject = LazyObjectHelper::createLazyObjectByArgumentsGetter(
            className: NormalClass::class,
            argumentsGetter: function () use ($data) {
                return [
                    'data' => $data,
                ];
            },
        );

        $this->runAsserts($data, $lazyObject);
    }

    #[Test]
    #[DataProvider('dataProvider')]
    public function createLazyObjectByInitializer($data): void
    {
        $lazyObject =  LazyObjectHelper::createLazyObjectByInitializer(
            className: NormalClass::class,
            initializer: static fn ($object) => $object->__construct(
                data: $data,
            ),
        );

        $this->runAsserts($data, $lazyObject);
    }

    public static function dataProvider(): array
    {
        return [
            [
                'data' => (object) [
                    'isInitialized' => false,
                ],
            ],
        ];
    }

    protected function runAsserts($data, $lazyObject): void
    {
        $this->assertInstanceOf(NormalClass::class, $lazyObject);
        $this->assertSame(false, $data->isInitialized);
        $this->assertSame(true, $lazyObject->data->isInitialized);
        $this->assertSame(true, $data->isInitialized);
    }
}
