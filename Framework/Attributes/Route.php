<?php

namespace Framework\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS | Attribute::TARGET_METHOD)]
class Route
{
    public function __construct(
        public string $path,
        /**
         * @var string|string[]
         */
        public string|array|null $method = 'GET',
        public ?string $name = null
    ) {}
}
