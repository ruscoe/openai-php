<?php

namespace OpenAI;

/**
 * OpenAI API Edits library.
 *
 * @package OpenAI
 * @author  Dan Ruscoe <danruscoe@protonmail.com>
 * @license MIT https://mit-license.org/
 * @link    https://github.com/ruscoe/openai-php
 */
class OpenAIEdits extends OpenAI
{
    /**
     * Performs an edit on a given input.
     *
     * @param string $model       the model ID that should be used to create the edit
     *                            Example: text-davinci-edit-001
     *                            Check model compatibility for valid models
     * @param string $input       the input to edit
     * @param string $instruction a description of how the model perform the edit
     * @param array  $parameters  optional array of parameters to use
     *
     * @return object the edit object
     *
     * @see https://platform.openai.com/docs/api-reference/edits/create
     * @see https://platform.openai.com/docs/models/model-endpoint-compatibility
     */
    public function create($model, $input, $instruction, $parameters = [])
    {
        // Add required parameters.
        $parameters['model'] = $model;
        $parameters['input'] = $input;
        $parameters['instruction'] = $instruction;

        return $this->request('POST', '/edits', $parameters);
    }
}
