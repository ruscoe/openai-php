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
     * Transcribes text from an audio file.
     *
     * @param string $file       the path to the audio file
     * @param string $model      the ID of the model to use
     *                           currently only whisper-1
     *                           may be used
     * @param array  $parameters optional array of parameters to use
     *
     * @return object
     *
     * @see https://platform.openai.com/docs/api-reference/audio/create
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

        return $this->request('multipart', '/audio/transcriptions', $multipart);
    }
}
