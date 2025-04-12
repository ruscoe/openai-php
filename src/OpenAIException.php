<?php

namespace OpenAI;

use Exception;

/**
 * OpenAI API exception.
 *
 * @package OpenAI
 * @author  Dan Ruscoe <danruscoe@protonmail.com>
 * @license MIT https://mit-license.org/
 * @link    https://github.com/ruscoe/openai-php
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
