<?php

declare(strict_types=1);

namespace NickLai\LazyObject;

use NickLai\LazyObject\LazyObjectFactory;

/**
 * @template TClass of object
 */
class LazyObjectHelper
{
    /**
     * Create a lazy-initialization object.
     *
     * @param class-string<TClass>|TClass $className
     * @param mixed ...$arguments
     *
     * @return TClass
     */
    public static function createLazyObject(string|object $className, ...$arguments)
    {
        return static::createLazyObjectByInitializer(
            className: $className,
            initializer: static fn ($object) => $object->__construct(...$arguments)
        );
    }

    /**
     * Create a lazy-initialization object by arguments getter.
     *
     * @param class-string<TClass>|TClass $className
     * @param callable():array<mixed> $argumentsGetter
     *
     * @return TClass
     */
    public static function createLazyObjectByArgumentsGetter(string|object $className, callable $argumentsGetter)
    {
        return static::createLazyObjectByInitializer(
            className: $className,
            initializer: static fn ($object) => $object->__construct(...$argumentsGetter())
        );
    }

    /**
     * Create a lazy-initialization object by initializer.
     *
     * @param class-string<TClass>|TClass $className
     * @param callable(TClass):mixed $initializer
     *
     * @return TClass
     */
    public static function createLazyObjectByInitializer(string|object $className, callable $initializer)
    {
        return LazyObjectFactory::create($className)->createLazyObjectByInitializer($initializer);
    }
}
