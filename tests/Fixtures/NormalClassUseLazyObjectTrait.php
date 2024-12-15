<?php

declare(strict_types=1);

namespace NickLai\LazyObject\Tests\Fixtures;

use NickLai\LazyObject\LazyObjectTrait;

class NormalClassUseLazyObjectTrait extends NormalClass
{
    use LazyObjectTrait;
}
