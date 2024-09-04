<?php

namespace Framework\Serializer;

use ReflectionClass;

use function Src\Kernel\dd;

class JSONConverter implements Converter
{
    private static string $type = 'json';

    /**
     * Transform object into Associative Arrays
     * @param object $data
     * @return array<string, string>[]
     */
    private static function objectToArray(object $data)
    {
        $reflection = new ReflectionClass($data);
        $array = [];
        foreach ($reflection->getProperties() as $property) {
            //$array[] = [$property->getName() => $property->getValue($data)];
            $array[$property->getName()] = $property->getValue($data);
        }

        return $array;
    }

    /**
     * Transform object into JSON string
     * @param object $data
     * @return string|bool
     */
    private static function objectToJSON(object $data)
    {
        return json_encode(self::objectToArray($data));
    }

    public static function getType(): string
    {
        return self::$type;
    }

    public static function serialize(mixed $data): string
    {
        return self::objectToJSON($data) . PHP_EOL;
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
