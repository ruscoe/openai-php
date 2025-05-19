<?php

namespace OpenAI;

use GuzzleHttp\Psr7;

/**
 * OpenAI API Files library.
 *
 * @package OpenAI
 * @author  Dan Ruscoe <danruscoe@protonmail.com>
 * @license MIT https://mit-license.org/
 * @link    https://github.com/ruscoe/openai-php
 */
class OpenAIFiles extends OpenAI
{
    /**
     * Gets files owned by the user's organization.
     *
     * @return object
     *
     * @see https://platform.openai.com/docs/api-reference/files/list
     */
    public function getFiles()
    {
        return $this->request('GET', '/files');
    }

    /**
     * Uploads a file.
     *
     * @param string $file       the path to the file
     * @param string $purpose    the purpose of the file
     *                           `fine-tune` for fine
     *                           tuning files
     * @param array  $parameters optional array of parameters to use
     *
     * @return object
     *
     * @see https://platform.openai.com/docs/api-reference/files/create
     */
    public function uploadFile($file, $purpose = 'fine-tune', $parameters = [])
    {
        // Include file and purpose parameters in multipart data.
        $multipart = [
            [
                'name'     => 'file',
                'contents' => Psr7\Utils::tryFopen($file, 'r'),
            ],
            [
                'name'     => 'purpose',
                'contents' => $purpose,
            ],
        ];

        // Include parameters in multipart data.
        foreach ($parameters as $key => $value) {
            $multipart[] = [
                'name'     => $key,
                'contents' => $value,
            ];
        }

        return $this->request('multipart', '/files', $multipart);
    }

    /**
     * Deletes a file.
     *
     * @param string $file_id the ID of the file
     *
     * @return object
     *
     * @see https://platform.openai.com/docs/api-reference/files/delete
     */
    public function deleteFile($file_id)
    {
        return $this->request('DELETE', '/files/'.$file_id);
    }

    /**
     * Gets information about a file.
     *
     * @param string $file_id the ID of the file
     *
     * @return object
     *
     * @see https://platform.openai.com/docs/api-reference/files/retrieve
     */
    public function getFile($file_id)
    {
        return $this->request('GET', '/files/'.$file_id);
    }

    /**
     * Gets the content of a file.
     *
     * @param string $file_id the ID of the file
     *
     * @return string the file's content
     *
     * @see https://platform.openai.com/docs/api-reference/files/retrieve-content
     */
    public function getFileContent($file_id)
    {
        $options = [
            'stream' => true,
            'sink' => STDOUT
        ];

        return $this->request('GET', '/files/'.$file_id.'/content', [], $options);
    }
}
