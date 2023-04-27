<?php

namespace OpenAI;

use GuzzleHttp\Psr7;

/**
 * OpenAI API Audio library.
 *
 * @package OpenAI
 * @author  Dan Ruscoe <danruscoe@protonmail.com>
 * @license MIT https://mit-license.org/
 * @link    https://github.com/ruscoe/openai-php
 */
class OpenAIAudio extends OpenAI
{
    /**
     * Instructs OpenAI to transcribe text from an audio file.
     *
     * @see https://platform.openai.com/docs/api-reference/audio/create
     *
     * @param string $file       the path to the audio file
     * @param string $model      the ID of the model to use
     *                           currently only whisper-1
     *                           may be used
     * @param array  $parameters optional array of parameters to use
     *
     * @return string the transcribed text
     */
    public function transcribe($file, $model = 'whisper-1', $parameters = [])
    {
        // Include file and model in multipart data.
        $multipart = [
            [
                'name'     => 'file',
                'contents' => Psr7\Utils::tryFopen($file, 'r'),
            ],
            [
                'name'     => 'model',
                'contents' => $model,
            ],
        ];

        // Include parameters in multipart data.
        foreach ($parameters as $key => $value) {
            $multipart[] = [
                'name'     => $key,
                'contents' => $value,
            ];
        }

        $response = $this->request('multipart', '/audio/transcriptions', $multipart);

        return (isset($response->text)) ? $response->text : null;

        return $response;
    }
}
