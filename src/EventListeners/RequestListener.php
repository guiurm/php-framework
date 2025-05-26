<?php

namespace App\EventListeners;

use Framework\Events\Event;
use Framework\Events\EventDispatcher;


class RequestListener extends EventDispatcher
{
    public function handle(Event $event)
    {

        echo "RequestListener: Handling request event\n";
        // Tu lógica para manejar el evento de request aquí
        // Por ejemplo, puedes acceder a la request:


        // Realiza acciones según sea necesario
    }
}
