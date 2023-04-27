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
     * Instructs OpenAI to generate an image / some images from a given input, returning URL(s).
     *
     * @see https://platform.openai.com/docs/api-reference/images/create
     *
     * @param string $prompt     a description of the image to generate
     * @param int    $number     the number of images to generate
     * @param string $size       the size in pixels of the image
     *                           256x256, 512x512, or 1024x1024
     * @param array  $parameters optional array of parameters to use
     *
     * @return array a URL for each image generated
     */
    public function createAsURL($prompt, $number = 1, $size = '1024x1024', $parameters = [])
    {
        // Add required parameters.
        $parameters['prompt'] = $prompt;
        $parameters['n'] = $number;
        $parameters['size'] = $size;

        // Enforce response format as URL for this function.
        $parameters['response_format'] = 'url';

        $response = $this->request('POST', '/images/generations', $parameters);

        if (isset($response->data)) {
            $urls = [];

            foreach ($response->data as $object)
            {
                $urls[] = $object->url;
            }

            return $urls;
        }

        return null;
    }

    /**
     * Instructs OpenAI to generate an image / some images from a given input, returning Base64 encoded image(s).
     *
     * @see https://platform.openai.com/docs/api-reference/images/create
     *
     * @param string $prompt     a description of the image to generate
     * @param int    $number     the number of images to generate
     * @param string $size       the size in pixels of the image
     *                           256x256, 512x512, or 1024x1024
     * @param array  $parameters optional array of parameters to use
     *
     * @return array a URL for each image generated
     */
    public function createAsBase64($prompt, $number = 1, $size = '1024x1024', $parameters = [])
    {
        // Add required parameters.
        $parameters['prompt'] = $prompt;
        $parameters['n'] = $number;
        $parameters['size'] = $size;

        // Enforce response format as b64_json for this function.
        $parameters['response_format'] = 'b64_json';

        $response = $this->request('POST', '/images/generations', $parameters);

        if (isset($response->data)) {
            $images = [];

            foreach ($response->data as $object)
            {
                $images[] = $object->b64_json;
            }

            return $images;
        }

        return null;
    }

    /**
     * Instructs OpenAI to generate an image / some image variations from a given image, returning URL(s).
     *
     * @see https://platform.openai.com/docs/api-reference/images/create-variation
     *
     * @param string $image      the path to the image file
     * @param int    $number     the number of images to generate
     * @param string $size       the size in pixels of the image
     *                           256x256, 512x512, or 1024x1024
     * @param array  $parameters optional array of parameters to use
     *
     * @return array a URL for each image generated
     */
    public function createVariationAsURL($image, $number = 1, $size = '1024x1024', $parameters = [])
    {
        // Add required parameters.
        $parameters['n'] = $number;
        $parameters['size'] = $size;

        // Enforce response format as url for this function.
        $parameters['response_format'] = 'url';

        $response = $this->createVariation($image, $parameters);

        if (isset($response->data)) {
            $urls = [];

            foreach ($response->data as $object)
            {
                $urls[] = $object->url;
            }

            return $urls;
        }

        return null;
    }

    /**
     * Instructs OpenAI to generate an image / some image variations from a given image, returning Base64 encoded image(s).
     *
     * @see https://platform.openai.com/docs/api-reference/images/create-variation
     *
     * @param string $image      the path to the image file
     * @param int    $number     the number of images to generate
     * @param string $size       the size in pixels of the image
     *                           256x256, 512x512, or 1024x1024
     * @param array  $parameters optional array of parameters to use
     *
     * @return array a URL for each image generated
     */
    public function createVariationAsBase64($image, $number = 1, $size = '1024x1024', $parameters = [])
    {
        // Add required parameters.
        $parameters['n'] = $number;
        $parameters['size'] = $size;

        // Enforce response format as b64_json for this function.
        $parameters['response_format'] = 'b64_json';

        $response = $this->createVariation($image, $parameters);

        if (isset($response->data)) {
            $images = [];

            foreach ($response->data as $object)
            {
                $images[] = $object->b64_json;
            }

            return $images;
        }

        return null;
    }

    /**
     * Instructs OpenAI to generate an image / some image variations from a given image.
     *
     * @see https://platform.openai.com/docs/api-reference/images/create-variation
     *
     * @param string $image      the path to the image file
     * @param array  $parameters optional array of parameters to use
     *
     * @return object the image variation response object
     */
    public function createVariation($image, $parameters = [])
    {
        // Include image parameter in multipart data.
        $multipart = [
            [
                'name'     => 'image',
                'contents' => Psr7\Utils::tryFopen($image, 'r'),
            ],
        ];

        // Include parameters in multipart data.
        foreach ($parameters as $key => $value) {
            $multipart[] = [
                'name' => $key,
                'contents' => $value,
            ];
        }

        $response = $this->request('multipart', '/images/variations', $multipart);

        return $response;
    }
}
