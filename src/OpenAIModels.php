<?php

namespace OpenAI;

/**
 * OpenAI API Models library.
 *
 * @package OpenAI
 * @author  Dan Ruscoe <danruscoe@protonmail.com>
 * @license MIT https://mit-license.org/
 * @link    https://github.com/ruscoe/openai-php
 */
class OpenAIModels extends OpenAI
{
    /**
     * Gets available OpenAI models.
     *
     * @see https://platform.openai.com/docs/api-reference/models/list
     * 
     * @return array an array of OpenAI model objects
     */
    public function getModels()
    {
        $response = $this->request('GET', '/models');

        return (isset($response->data)) ? $response->data : null;
    }

    /**
     * Gets a specific OpenAI model.
     *
     * @see https://platform.openai.com/docs/api-reference/models/retrieve
     *
     * @param string $model the model ID
     *                      Example: gpt-3.5-turbo
     *
     * @return array an array of OpenAI model objects
     */
    public function getModel($model)
    {
        return $this->request('GET', '/models/'.$model);
    }
}
