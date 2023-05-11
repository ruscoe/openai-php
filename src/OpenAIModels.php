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
     * @return object
     *
     * @see https://platform.openai.com/docs/api-reference/models/list
     */
    public function getModels()
    {
        return $this->request('GET', '/models');
    }

    /**
     * Gets a specific OpenAI model.
     *
     * @param string $model the model ID
     *                      Example: gpt-3.5-turbo
     *
     * @return object
     *
     * @see https://platform.openai.com/docs/api-reference/models/retrieve
     */
    public function getModel($model)
    {
        return $this->request('GET', '/models/'.$model);
    }
}
