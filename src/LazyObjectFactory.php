<?php

declare(strict_types=1);

namespace NickLai\LazyObject;

use ReflectionClass;

/**
 * @template TClass of object
 * @phpstan-consistent-constructor
 */
class LazyObjectFactory
{
    /**
     * @var ReflectionClass<TClass>
     */
    protected ReflectionClass $reflectionClass;

    /**
     * @param class-string<TClass>|TClass $className
     */
    public function __construct(
        public readonly string|object $className,
    ) {
        $this->reflectionClass = new ReflectionClass($className);
    }

    /**
     * Create a lazy-initialization object.
     *
     * @param mixed ...$arguments
     *
     * @return TClass
     */
    public function createLazyObject(...$arguments)
    {
        return $this->createLazyObjectByInitializer(
            initializer: static fn ($object) => $object->__construct(...$arguments),
        );
    }

    /**
     * Create a lazy-initialization object by arguments getter.
     *
     * @param callable():array<mixed> $argumentsGetter
     *
     * @return TClass
     */
    public function createLazyObjectByArgumentsGetter(callable $argumentsGetter)
    {
        return $this->createLazyObjectByInitializer(
            initializer: static fn ($object) => $object->__construct(...$argumentsGetter()),
        );
    }

    /**
     * Create a lazy-initialization object by initializer.
     *
     * @param callable(TClass):mixed $initializer
     *
     * @return TClass
     */
    public function createLazyObjectByInitializer(callable $initializer)
    {
        return $this->reflectionClass->newLazyGhost(
            initializer: $initializer,
        );
    }

    /**
     * Create a factory instance by class name.
     *
     * @param class-string<TClass>|TClass $className
     */
    public static function create(string|object $className): static
    {
        return new static(
            className: $className,
        );
    }
}
