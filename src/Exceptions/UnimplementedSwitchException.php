<?php

namespace Trafficgate\Exceptions;

use Exception;

class UnimplementedSwitchException extends Exception
{
    /**
     * Create a new object.
     *
     * This exception is thrown when a switch is not yet implemented.
     *
     * @param string    $switch
     * @param int       $code
     * @param Throwable $previous
     */
    public function __construct($switch = '', $code = 0, $previous = null)
    {
        $message = "The switch {$switch} is not yet implemented!";

        parent::__construct($message, $code, $previous);
    }
}
