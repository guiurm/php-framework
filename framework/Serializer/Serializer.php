<?php

namespace Framework\Serializer;

use ReflectionClass;

use function Src\Kernel\dd;

interface SerializerInterface
{
    /**
     * Serializa un objeto a formato JSON.
     *
     * @param mixed $object El objeto a serializar.
     * @return string La representación JSON del objeto.
     */
    public function serialize(mixed $data, string $format, array $context = []);
    public function supportsSerialization(string $format): bool;

    /**
     * Serializa un array de objetos a formato JSON.
     *
     * @param array $objects El array de objetos a serializar.
     * @return string La representación JSON del array de objetos.
     */
    public function serializeCollection(array $objects): string;
}

class Serializer implements SerializerInterface
{
    private array $converters;
    public function __construct()
    {
        $this->converters[JSONConverter::getType()] = new JSONConverter();
    }
    /**
     * Transform object into json
     * @param mixed $data
     * @return string
     */
    public function serialize(mixed $data, string $format, array $context = []): string
    {
        if (!$this->supportsSerialization($format)) {
            throw new \InvalidArgumentException("Not suported format: $format");
        }
        return $this->converters[JSONConverter::getType()]->serialize($data);
        //return self::objectToJSON($data) . PHP_EOL;
    }

    public function supportsSerialization(string $format): bool
    {
        return isset($this->converters[$format]);
    }

    public function serializeCollection(array $objects): string
    {
        return '';
    }
}
