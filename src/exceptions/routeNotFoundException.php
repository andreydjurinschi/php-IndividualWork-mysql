<?php

class routeNotFoundException extends Exception{
    public function __construct($message, $code = 404, Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}