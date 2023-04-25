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
     * Instructs OpenAI to create one or more completions from a given input.
     *
     * @see https://platform.openai.com/docs/api-reference/completions/create
     *
     * @param string $model      the model ID that should be used to create the completion
     *                           Example:
     *                           text-davinci-003
     *                           Check model compatibility for valid models
     *                           https://platform.openai.com/docs/models/model-endpoint-compatibility
     * @param mixed  $prompt     optional prompt(s) to generate a completion for (string or array)
     * @param int    $number     number of completions to create
     * @param array  $parameters optional array of parameters to use
     *
     * @return array of completion objects
     */
    public function create($model, $prompt = null, $number = 1, $parameters = [])
    {
        // Add required parameters.
        $parameters['model'] = $model;
        $parameters['prompt'] = $prompt;
        $parameters['n'] = $number;

        $response = $this->request('POST', '/completions', $parameters);

        return (isset($response->choices)) ? $response->choices : null;
    }
}
