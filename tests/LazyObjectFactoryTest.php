<?php

declare(strict_types=1);

namespace NickLai\LazyObject\Tests;

use NickLai\LazyObject\LazyObjectFactory;
use NickLai\LazyObject\Tests\Fixtures\NormalClass;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(LazyObjectFactory::class)]
final class LazyObjectFactoryTest extends TestCase
{
    #[Test]
    public function create(): void
    {
        $lazyObjectFactory = LazyObjectFactory::create(NormalClass::class);

        $this->assertInstanceOf(LazyObjectFactory::class, $lazyObjectFactory);
    }

    #[Test]
    #[DataProvider('dataProvider')]
    public function createLazyObject($data, $lazyObjectFactory): void
    {
        $lazyObject = $lazyObjectFactory->createLazyObject(
            data: $data,
        );

        $this->runAsserts($data, $lazyObject);
    }

    #[Test]
    #[DataProvider('dataProvider')]
    public function createLazyObjectByArgumentsGetter($data, $lazyObjectFactory): void
    {
        $lazyObject = $lazyObjectFactory->createLazyObjectByArgumentsGetter(
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
    public function createLazyObjectByInitializer($data, $lazyObjectFactory): void
    {
        $lazyObject =  $lazyObjectFactory->createLazyObjectByInitializer(
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
                'lazyObjectFactory' => LazyObjectFactory::create(NormalClass::class),
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
