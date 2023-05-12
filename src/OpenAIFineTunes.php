<?php

namespace OpenAI;

/**
 * OpenAI API Fine-Tunes library.
 *
 * @package OpenAI
 * @author  Dan Ruscoe <danruscoe@protonmail.com>
 * @license MIT https://mit-license.org/
 * @link    https://github.com/ruscoe/openai-php
 * @see     https://platform.openai.com/docs/guides/fine-tuning
 */
class OpenAIFineTunes extends OpenAI
{
    /**
     * Creates a fine-tune job.
     * 
     * @param string $training_file the ID of the file to use for fine-tuning data.
     * 
     * @return object
     *
     * @see https://platform.openai.com/docs/api-reference/fine-tunes/create
     */
    public function create($training_file, $parameters = [])
    {
        // Add required parameters.
        $parameters['training_file'] = $training_file;

        return $this->request('POST', '/fine-tunes', $parameters);
    }

    /**
     * Gets existing fine-tunes.
     * 
     * @return object
     *
     * @see https://platform.openai.com/docs/api-reference/fine-tunes/list
     */
    public function getFineTunes()
    {
        return $this->request('GET', '/fine-tunes');
    }

    /**
     * Cancels a fine-tune job.
     *
     * @param string $fine_tune_id the fine-tune ID
     *
     * @return object
     *
     * @see https://platform.openai.com/docs/api-reference/fine-tunes/cancel
     */
    public function cancelFineTune($fine_tune_id)
    {
        return $this->request('POST', '/fine-tunes/'.$fine_tune_id);
    }

    /**
     * Gets status updates of a fine-tune job.
     * 
     * @param string $fine_tune_id the fine-tune ID
     * 
     * @return object
     *
     * @see https://platform.openai.com/docs/api-reference/fine-tunes/events
     */
    public function getFineTuneEvents($fine_tune_id)
    {
        return $this->request('GET', '/fine-tunes/'.$fine_tune_id.'/events');
    }

    /**
     * Deletes a fine-tuned model.
     *
     * @param string $model the model ID
     *
     * @return object
     *
     * @see https://platform.openai.com/docs/api-reference/fine-tunes/delete-model
     */
    public function deleteModel($model)
    {
        return $this->request('DELETE', '/models/'.$model);
    }
}
