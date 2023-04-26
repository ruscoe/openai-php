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
     * Instructs OpenAI to create one or more completions from a chat conversation.
     *
     * @see https://platform.openai.com/docs/api-reference/chat/create
     *
     * @param string $model      the model ID that should be used to create the completion
     *                           Example:
     *                           gpt-3.5-turbo
     *                           Check model compatibility for valid models
     *                           https://platform.openai.com/docs/models/model-endpoint-compatibility
     * @param mixed  $messages   array of objects representing messages in the conversation
     *                           [{'role': 'user', 'content': 'Hello, friend!'}]
     * @param array  $parameters optional array of parameters to use
     *
     * @return array array of completion objects
     */
    public function create($model, $messages, $parameters = [])
    {
        // Add required parameters.
        $parameters['model'] = $model;
        $parameters['messages'] = $messages;

        $response = $this->request('POST', '/chat/completions', $parameters);

        return (isset($response->choices)) ? $response->choices : null;
    }
}
