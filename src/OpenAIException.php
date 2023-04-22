<?php

namespace OpenAI;

use \Exception;

/**
 * OpenAI API exception.
 *
 * @package OpenAI
 */
class OpenAIException extends Exception
{
    /**
     * @inheritdoc
     */
    public function __construct($message = "", $code = 0, Exception $previous = null)
    {

        // TODO: Custom exception handling here.
        parent::__construct($message, $code, $previous);
    }

}
