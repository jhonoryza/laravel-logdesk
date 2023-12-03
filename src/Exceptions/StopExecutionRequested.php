<?php

namespace Jhonoryza\Logdesk\Exceptions;

use Exception;
class StopExecutionRequested extends Exception
{
    public static function make(): self
    {
        return new static("This exception is thrown because you requested to stop the execution in Ray.");
    }
}
