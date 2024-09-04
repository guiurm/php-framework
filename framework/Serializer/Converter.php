<?php

namespace Framework\Serializer;

use ReflectionClass;

interface Converter
{
    public static function getType(): string;
    public static function serialize(mixed $data): string;
    public static function deserialize(string $data, string $className): mixed;
}
