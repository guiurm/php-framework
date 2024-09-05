<?php

namespace Framework\Serializer;

use ReflectionClass;

class JSONConverter implements Converter
{
    private static string $type = 'json';

    public static function getType(): string
    {
        return self::$type;
    }

    public static function serialize(mixed $data): string
    {
        $reflection = new ReflectionClass($data);
        $array = [];
        foreach ($reflection->getProperties() as $property) {
            $array[$property->getName()] = $property->getValue($data);
        }

        return json_encode($array) . PHP_EOL;
    }

    public static function deserialize(string $data, string $className): mixed
    {
        $parsedArray = json_decode($data, true);
        $reflection = new ReflectionClass($className);
        $instance = $reflection->newInstance();
        foreach ($reflection->getProperties() as $key => $property) {
            $property->setAccessible(true);
            $property->setValue($instance, $parsedArray[$property->getName()] ?? null);
        }

        return $instance;
    }
}
