<?php

namespace App\Exceptions;

use Exception;

class ModelHasTasksException extends Exception
{
    public function __construct($message = "this status is associated with tasks!")
    {
        parent::__construct($message);
    }
}
