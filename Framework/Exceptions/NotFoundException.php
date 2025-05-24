<?php

namespace Framework\Exceptions;

use Exception;

/**
 * Class NotFoundException
 * @package Framework\Exceptions
 *
 * This exception is thrown when a requested resource is not found.
 */
class NotFoundException extends Exception
{
    public function __construct($message = "Not Found", $code = 404)
    {
        parent::__construct($message, $code);
    }
}
