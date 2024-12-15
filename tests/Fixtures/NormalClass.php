<?php

declare(strict_types=1);

namespace NickLai\LazyObject\Tests\Fixtures;

use stdClass;

class NormalClass
{
    public function __construct(
        public stdClass $data,
    ) {
        $this->data->isInitialized = true;
    }
}
