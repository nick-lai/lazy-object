[![PSR-12](https://github.com/nick-lai/lazy-object/actions/workflows/psr-12.yml/badge.svg)](https://github.com/nick-lai/lazy-object/actions/workflows/psr-12.yml)
[![Static Analysis](https://github.com/nick-lai/lazy-object/actions/workflows/static-analysis.yml/badge.svg)](https://github.com/nick-lai/lazy-object/actions/workflows/static-analysis.yml)
[![Tests](https://github.com/nick-lai/lazy-object/actions/workflows/tests.yml/badge.svg)](https://github.com/nick-lai/lazy-object/actions/workflows/tests.yml)
[![Coverage Status](https://coveralls.io/repos/github/nick-lai/lazy-object/badge.svg?branch=main)](https://coveralls.io/github/nick-lai/lazy-object?branch=main)
[![PHP Version Require](https://poser.pugx.org/nick-lai/lazy-object/require/php)](https://packagist.org/packages/nick-lai/lazy-object)
[![Latest Stable Version](https://poser.pugx.org/nick-lai/lazy-object/v)](https://packagist.org/packages/nick-lai/lazy-object)
[![Total Downloads](https://poser.pugx.org/nick-lai/lazy-object/downloads)](https://packagist.org/packages/nick-lai/lazy-object/stats)

# LazyObject

**A lightweight [lazy object](https://www.php.net/manual/en/language.oop5.lazy-objects.php) library for PHP.**

## Table of Contents

- [LazyObject](#lazyobject)
  - [Table of Contents](#table-of-contents)
  - [Requirements](#requirements)
  - [Installation](#installation)
  - [Usage](#usage)
    - [`LazyObjectTrait`](#lazyobjecttrait)
    - [`LazyObjectFactory`](#lazyobjectfactory)
    - [`LazyObjectHelper`](#lazyobjecthelper)
  - [License](#license)

## Requirements

LazyObject requires PHP >= 8.4.0.

## Installation

```sh
composer require nick-lai/lazy-object
```

## Usage

### `LazyObjectTrait`

```php
use NickLai\LazyObject\LazyObjectTrait;

class NormalClass
{
    use LazyObjectTrait;

    public function __construct(
        public string $name,
    ) {
        echo 'Initialized.' . PHP_EOL;
    }
}

// Output: Initialized.
$normalClass = new NormalClass('Tom');
// Output: Hi, Tom!
echo "Hi, {$normalClass->name}!" . PHP_EOL;

$lazyObject = NormalClass::createLazyObject('Jerry');
// Outputs:
// Initialized.
// Hi, Jerry!
echo "Hi, {$lazyObject->name}!" . PHP_EOL;

$lazyObject = NormalClass::createLazyObjectByArgumentsGetter(fn () => [
    'name' => 'Spike',
]);
// Outputs:
// Initialized.
// Hi, Spike!
echo "Hi, {$lazyObject->name}!" . PHP_EOL;
```

### `LazyObjectFactory`

```php
use NickLai\LazyObject\LazyObjectFactory;

class NormalClass
{
    public function __construct(
        public string $name,
    ) {
        echo 'Initialized.' . PHP_EOL;
    }
}

$lazyObjectFactory = LazyObjectFactory::create(NormalClass::class);
$lazyObject = $lazyObjectFactory->createLazyObject('Jerry');
// Outputs:
// Initialized.
// Hi, Jerry!
echo "Hi, {$lazyObject->name}!" . PHP_EOL;
```

### `LazyObjectHelper`

```php
use NickLai\LazyObject\LazyObjectHelper;

class NormalClass
{
    public function __construct(
        public string $name,
    ) {
        echo 'Initialized.' . PHP_EOL;
    }
}

$lazyObject = LazyObjectHelper::createLazyObject(
    className: NormalClass::class,
    arguments: [
        'name' => 'Jerry',
    ],
);
// Outputs:
// Initialized.
// Hi, Jerry!
echo "Hi, {$lazyObject->name}!" . PHP_EOL;
```

## License

LazyObject is released under the [MIT](LICENSE) License. See the bundled LICENSE file for details.
