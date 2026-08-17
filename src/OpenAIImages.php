<?php

namespace OpenAI;

use GuzzleHttp\Psr7;

/**
 * OpenAI API Images library.
 *
 * @package OpenAI
 * @author  Dan Ruscoe <danruscoe@protonmail.com>
 * @license MIT https://mit-license.org/
 * @link    https://github.com/ruscoe/openai-php
 */
class OpenAIImages extends OpenAI
{
    /**
     * Generates a number of images as files.
     *
     * @param string $model      the model ID to use when creating the image
     *                           Example:
     *                           gpt-image-2
     * @param string $prompt     a description of the image to generate
     * @param string $output     the output filename
     *                           Example:
     *                           waterfall.png
     *                           Note that if $number if set to a value greater than
     *                           1, multiple files will be created. Example:
     *                           1_waterfall.png
     *                           2_waterfall.png
     * @param int    $number     the number of images to generate
     * @param string $size       the size in pixels of the image
     *                           256x256, 512x512, or 1024x1024
     * @param array  $parameters optional array of parameters to use
     *
     * @return bool true if images have been generated
     *
     * @see https://developers.openai.com/api/reference/resources/images/methods/generate
     */
    public function createAsFile($model, $prompt, $output, $number = 1, $size = '1024x1024', $parameters = [])
    {
        // Add required parameters.
        $parameters['model'] = $model;
        $parameters['prompt'] = $prompt;
        $parameters['n'] = $number;
        $parameters['size'] = $size;

        $response = $this->request('POST', '/images/generations', $parameters);

        $count = 1;
        if (isset($response->data)) {
            foreach ($response->data as $object) {
                $image = base64_decode($object->b64_json, true);

                $filename = $output;
                if ($number > 1) {
                    $filename = $count . '_' . $filename;
                }

                if (file_put_contents($filename, $image) === false) {
                    throw new OpenAIException('Unable to write file output.');
                }

                $count++;
            }

            return true;
        }

        return false;
    }

    /**
     * Generates a number of images and returns Base64 encoded image(s).
     *
     * @param string $model      the model ID to use when creating the image
     *                           Example:
     *                           gpt-image-2
     * @param string $prompt     a description of the image to generate
     * @param int    $number     the number of images to generate
     * @param string $size       the size in pixels of the image
     *                           256x256, 512x512, or 1024x1024
     * @param array  $parameters optional array of parameters to use
     *
     * @return array base64 data for each image generated
     *
     * @see https://developers.openai.com/api/reference/resources/images/methods/generate
     */
    public function createAsBase64($model, $prompt, $output, $number = 1, $size = '1024x1024', $parameters = [])
    {
        // Add required parameters.
        $parameters['model'] = $model;
        $parameters['prompt'] = $prompt;
        $parameters['n'] = $number;
        $parameters['size'] = $size;

        $response = $this->request('POST', '/images/generations', $parameters);

        if (isset($response->data)) {
            $images = [];

            foreach ($response->data as $object) {
                $images[] = $object->b64_json;
            }

            return $images;
        }

        return null;
    }

    /**
     * Generates a number of image edits as files.
     *
     * @param string $model      the model ID to use when creating the image
     *                           Example:
     *                           gpt-image-2
     * @param string $image      the path to the image file
     * @param string $prompt     a description of the edit to make
     * @param string $output     the output filename
     *                           Example:
     *                           edit.png
     *                           Note that if $number if set to a value greater than
     *                           1, multiple files will be created. Example:
     *                           1_edit.png
     *                           2_edit.png
     * @param string $mask       the path to the mask image file
     * @param int    $number     the number of images to generate
     * @param string $size       the size in pixels of the image
     *                           256x256, 512x512, or 1024x1024
     * @param array  $parameters optional array of parameters to use
     *
     * @return bool true if images have been generated
     *
     * @see https://developers.openai.com/api/reference/resources/images/methods/edit
     */
    public function createEditAsFile($model, $image, $prompt, $output, $mask = null, $number = 1, $size = '1024x1024', $parameters = [])
    {
        // Add required parameters.
        $parameters['model'] = $model;
        $parameters['n'] = $number;
        $parameters['size'] = $size;

        $response = $this->createEdit($image, $prompt, $mask, $parameters);

        $count = 1;
        if (isset($response->data)) {
            foreach ($response->data as $object) {
                $image = base64_decode($object->b64_json, true);

                $filename = $output;
                if ($number > 1) {
                    $filename = $count . '_' . $filename;
                }

                if (file_put_contents($filename, $image) === false) {
                    throw new OpenAIException('Unable to write file output.');
                }

                $count++;
            }

            return true;
        }

        return false;
    }

    /**
     * Generates a number of image edits and returns Base64 encoded image(s).
     *
     * @param string $image      the path to the image file
     * @param string $prompt     a description of the edit to make
     * @param string $mask       the path to the mask image file
     * @param int    $number     the number of images to generate
     * @param string $size       the size in pixels of the image
     *                           256x256, 512x512, or 1024x1024
     * @param array  $parameters optional array of parameters to use
     *
     * @return array base64 data for each image generated
     *
     * @see https://developers.openai.com/api/reference/resources/images/methods/edit
     */
    public function createEditAsBase64($image, $prompt, $mask = null, $number = 1, $size = '1024x1024', $parameters = [])
    {
        // Add required parameters.
        $parameters['n'] = $number;
        $parameters['size'] = $size;

        // Enforce response format as b64_json for this function.
        $parameters['response_format'] = 'b64_json';

        $response = $this->createEdit($image, $prompt, $mask, $parameters);

        if (isset($response->data)) {
            $images = [];

            foreach ($response->data as $object) {
                $images[] = $object->b64_json;
            }

            return $images;
        }

        return null;
    }

    /**
     * Generates a number of image edits from a given image.
     *
     * @param string $image      the path to the image file
     * @param string $prompt     a description of the edit to make
     * @param string $mask       the path to the mask image file
     * @param array  $parameters optional array of parameters to use
     *
     * @return object
     *
     * @see https://developers.openai.com/api/reference/resources/images/methods/edit
     */
    public function createEdit($image, $prompt, $mask = null, $parameters = [])
    {
        $parameters['prompt'] = $prompt;

        // Include image parameter in multipart data.
        $multipart = [
            [
                'name'     => 'image',
                'contents' => Psr7\Utils::tryFopen($image, 'r'),
            ],
        ];

        // Include optional image mask in multipart data.
        if ($mask !== null) {
            $multipart[] = [
                'name'     => 'mask',
                'contents' => Psr7\Utils::tryFopen($mask, 'r'),
            ];
        }

        // Include parameters in multipart data.
        foreach ($parameters as $key => $value) {
            $multipart[] = [
                'name'     => $key,
                'contents' => $value,
            ];
        }

        return $this->request('multipart', '/images/edits', $multipart);
    }
}
