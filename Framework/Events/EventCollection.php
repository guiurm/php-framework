<?php

namespace Framework\Collections;

use Framework\Events\Event;

/**
 * AbsCollection
 *
 * Esta clase abstracta proporciona una implementación básica para manejar una colección de elementos.
 * Permite agregar, eliminar, obtener y manipular elementos de manera sencilla.
 *
 * @package Framework\Collections
 */

class EventCollection extends AbsCollection
{
    /**
     * @var string
     */
    protected string $type = 'event';
}
