<?php

namespace Exceptions;

class DataAccessException extends \Exception
{
    public function __construct($message, $status = 400)
    {
        parent::__construct($message, $status);
    }
}