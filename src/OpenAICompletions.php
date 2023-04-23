<?php

namespace OpenAI;

/**
 * OpenAI API Completions library.
 *
 * @package OpenAI
 */
class OpenAICompletions extends OpenAI
{
    /**
     * Gets a specific OpenAI model.
     *
     * @see https://platform.openai.com/docs/api-reference/completions/create
     *
     * @param string $model      the model ID that should be used to create the completion
     *                           Example:
     *                           text-davinci-003
     *                           Check model compatibility for valid models
     *                           https://platform.openai.com/docs/models/model-endpoint-compatibility
     * @param array  $parameters optional array of parameters to use
     *
     * @return object the completion object
     */
    public function create($model, $parameters = [])
    {
        // Add required model parameter.
        $parameters['model'] = $model;

        return $this->request('POST', '/completions', $parameters);
    }
}
