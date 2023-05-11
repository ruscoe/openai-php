<?php

namespace OpenAI;

/**
 * OpenAI API Embeddings library.
 *
 * @package OpenAI
 * @author  Dan Ruscoe <danruscoe@protonmail.com>
 * @license MIT https://mit-license.org/
 * @link    https://github.com/ruscoe/openai-php
 */
class OpenAIEmbeddings extends OpenAI
{
    /**
     * Creates an embedding vector from given input.
     *
     * @param string $model      the model ID to use when creating the completion
     *                           Example:
     *                           text-embedding-ada-002
     *                           Check model compatibility for valid models
     * @param mixed  $input      the input to generate an embedding vector for
     *                           (string or array of strings)
     * @param array  $parameters optional array of parameters to use
     *
     * @return object
     *
     * @see https://platform.openai.com/docs/api-reference/embeddings/create
     * @see https://platform.openai.com/docs/models/model-endpoint-compatibility
     */
    public function create($model, $input = null, $parameters = [])
    {
        // Add required parameters.
        $parameters['model'] = $model;
        $parameters['input'] = $input;

        return $this->request('POST', '/embeddings', $parameters);
    }
}
