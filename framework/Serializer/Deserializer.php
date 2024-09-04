<?php

namespace Framework\Serializer;

use src\Models\User;

interface DeserializerInterface
{
    /**
     * Deserializa una cadena JSON a un objeto.
     *
     * @param string $json La cadena JSON a deserializar.
     * @param string $className El nombre de la clase del objeto a crear.
     * @return mixed El objeto resultante.
     */
    public function deserialize(mixed $data, string $format, string $class);
    public function supportsDeserialization(string $format): bool;
}

class Deserializer implements DeserializerInterface
{
    private array $converters;
    public function __construct()
    {
        $this->converters[JSONConverter::getType()] = new JSONConverter();
    }
    /**
     * Deserializa una cadena JSON a un objeto.
     *
     * @param string $json La cadena JSON a deserializar.
     * @param string $className El nombre de la clase del objeto a crear.
     * @return mixed El objeto resultante.
     */
    public function deserialize(mixed $data, string $format, string $class)
    {
        if (!$this->supportsDeserialization($format)) {
            throw new \InvalidArgumentException("Not suported format: $format");
        }
        return $this->converters[JSONConverter::getType()]->deserialize($data, $class);
    }

    public function supportsDeserialization(string $format): bool
    {
        return isset($this->converters[$format]);
    }
}
