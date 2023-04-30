<?php

namespace OpenAI;

/**
 * OpenAI API Moderations library.
 *
 * @package OpenAI
 * @author  Dan Ruscoe <danruscoe@protonmail.com>
 * @license MIT https://mit-license.org/
 * @link    https://github.com/ruscoe/openai-php
 */
class OpenAIModerations extends OpenAI
{
    /**
     * Requests a moderation result from OpenAI.
     *
     * @param mixed $input      input(s) to request moderation result(s) for
     *                          (string or array)
     * @param array $parameters optional array of parameters to use
     *
     * @return array array of moderation result objects
     *
     * @see https://platform.openai.com/docs/api-reference/moderations/create
     */
    public function create($input, $parameters = [])
    {
        // Add required parameters.
        $parameters['input'] = $input;

        $response = $this->request('POST', '/moderations', $parameters);

        return (isset($response->results)) ? $response->results : null;
    }
}
