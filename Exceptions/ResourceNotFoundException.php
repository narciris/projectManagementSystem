<?php

namespace Exceptions;

class ResourceNotFoundException extends \Exception
{
     public function __construct($message, $status = 400)
     {
         parent::__construct($message, $status);
     }
}