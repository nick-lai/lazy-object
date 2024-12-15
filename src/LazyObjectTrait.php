<?php

declare(strict_types=1);

namespace NickLai\LazyObject;

use NickLai\LazyObject\LazyObjectFactory;

trait LazyObjectTrait
{
    /**
     * Create a lazy-initialization object.
     *
     * @param mixed ...$arguments
     */
    public static function createLazyObject(...$arguments): static
    {
        return static::createLazyObjectByInitializer(
            initializer: static fn ($object) => $object->__construct(...$arguments)
        );
    }

    /**
     * Create a lazy-initialization object by arguments getter.
     *
     * @param callable():array<mixed> $argumentsGetter
     */
    public static function createLazyObjectByArgumentsGetter(callable $argumentsGetter): static
    {
        return static::createLazyObjectByInitializer(
            initializer: static fn ($object) => $object->__construct(...$argumentsGetter())
        );
    }

    /**
     * Create a lazy-initialization object by initializer.
     *
     * @param callable(static):mixed $initializer
     */
    public static function createLazyObjectByInitializer(callable $initializer): static
    {
        return LazyObjectFactory::create(static::class)->createLazyObjectByInitializer($initializer);
    }
}
