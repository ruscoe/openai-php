<?php

namespace OpenAI;

/**
 * OpenAI API Completions library.
 *
 * @package OpenAI
 * @author  Dan Ruscoe <danruscoe@protonmail.com>
 * @license MIT https://mit-license.org/
 * @link    https://github.com/ruscoe/openai-php
 */
class OpenAICompletions extends OpenAI
{
    /**
     * Creates one or more completions from a given input.
     *
     * @param string $model      the model ID to use when creating the completion
     *                           Example:
     *                           gpt-4o
     *                           Check model compatibility for valid models
     * @param mixed  $prompt     optional prompt(s) to generate a completion for
     *                           (string or array)
     * @param int    $number     number of completions to create
     * @param array  $parameters optional array of parameters to use
     *
     * @return object
     *
     * @see https://platform.openai.com/docs/api-reference/completions/create
     * @see https://platform.openai.com/docs/models/model-endpoint-compatibility
     */
    public function create($model, $messages = null, $number = 1, $parameters = [])
    {
        // Add required parameters.
        $parameters['model'] = $model;
        $parameters['messages'] = $messages;
        $parameters['n'] = $number;

        return $this->request('POST', '/chat/completions', $parameters);
    }
}
