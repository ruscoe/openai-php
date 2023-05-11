<?php

namespace OpenAI;

/**
 * OpenAI API Chat library.
 *
 * @package OpenAI
 * @author  Dan Ruscoe <danruscoe@protonmail.com>
 * @license MIT https://mit-license.org/
 * @link    https://github.com/ruscoe/openai-php
 */
class OpenAIChat extends OpenAI
{
    /**
     * Creates one or more completions from a chat conversation.
     *
     * @param string $model      the model ID to use when creating the completion
     *                           Example:
     *                           gpt-3.5-turbo
     *                           Check model compatibility for valid models
     * @param mixed  $messages   array of objects representing messages in the
     *                           conversation
     *                           [{'role': 'user', 'content': 'Hello, friend!'}]
     * @param array  $parameters optional array of parameters to use
     *
     * @return object
     *
     * @see https://platform.openai.com/docs/api-reference/chat/create
     * @see https://platform.openai.com/docs/models/model-endpoint-compatibility
     */
    public function create($model, $messages, $parameters = [])
    {
        // Add required parameters.
        $parameters['model'] = $model;
        $parameters['messages'] = $messages;

        return $this->request('POST', '/chat/completions', $parameters);
    }
}
