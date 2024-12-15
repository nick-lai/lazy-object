<?php

declare(strict_types=1);

namespace NickLai\LazyObject\Tests;

use NickLai\LazyObject\LazyObjectFactory;
use NickLai\LazyObject\LazyObjectTrait;
use NickLai\LazyObject\Tests\Fixtures\NormalClassUseLazyObjectTrait;
use PHPUnit\Framework\Attributes\CoversTrait;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversTrait(LazyObjectTrait::class)]
#[UsesClass(LazyObjectFactory::class)]
final class LazyObjectTraitTest extends TestCase
{
    #[Test]
    #[DataProvider('dataProvider')]
    public function createLazyObject($data): void
    {
        $lazyObject = NormalClassUseLazyObjectTrait::createLazyObject(
            data: $data,
        );

        $this->runAsserts($data, $lazyObject);
    }

    #[Test]
    #[DataProvider('dataProvider')]
    public function createLazyObjectByArgumentsGetter($data): void
    {
        $lazyObject = NormalClassUseLazyObjectTrait::createLazyObjectByArgumentsGetter(
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
        $lazyObject =  NormalClassUseLazyObjectTrait::createLazyObjectByInitializer(
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
        $this->assertInstanceOf(NormalClassUseLazyObjectTrait::class, $lazyObject);
        $this->assertSame(false, $data->isInitialized);
        $this->assertSame(true, $lazyObject->data->isInitialized);
        $this->assertSame(true, $data->isInitialized);
    }
}
