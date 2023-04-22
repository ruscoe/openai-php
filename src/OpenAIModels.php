<?php

namespace OpenAI;

/**
 * OpenAI API Models library.
 *
 * @package OpenAI
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
}
