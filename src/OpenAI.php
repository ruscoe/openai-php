<?php

namespace OpenAI;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use OpenAI\OpenAIException;

/**
 * OpenAI API library.
 *
 * @package OpenAI
 * @author  Dan Ruscoe <danruscoe@protonmail.com>
 * @license MIT https://mit-license.org/
 * @link    https://github.com/ruscoe/openai-php
 */
class OpenAI
{
    /**
     * The API endpoint.
     */
    protected $endpoint = 'https://api.openai.com/v1';

    /**
     * The API key to use.
     */
    protected $api_key;

    /**
     * The HTTP client.
     */
    protected $client;

    /**
     * OpenAI library constructor.
     * 
     * @param string $api_key the API key to use
     */
    public function __construct($api_key)
    {
        $this->api_key = $api_key;

        $this->client = new Client();
    }

    /**
     * Makes a request to the OpenAI API.
     *
     * @param string $method     the method to use when making the request
     *                           GET, POST or form
     * @param string $path       the API path to request
     * @param array  $parameters parameters to send with the request
     *
     * @return mixed
     *
     * @throws OpenAIException
     */
    public function request($method, $path, $parameters = [])
    {
        $options = [
            // Set up authentication.
            'headers' => ['Authorization' => 'Bearer ' . $this->api_key],
        ];

        if ($method == 'GET') {
            // GET request parameters are included in the query string.
            $options['query'] = $parameters;
        }
        else if ($method == 'form') {
            // Form data may be submitted as multipart or form_params. Never both.
            if (isset($parameters['multipart'])) {
                $options['multipart'] = $parameters['multipart'];
            } else {
                $options['form_params'] = $parameters;
            }
        }
        else {
            // POST parameters are included in the request body as JSON.
            $options['json'] = (object) $parameters;
        }
  
        try {
            $url = $this->endpoint.$path;
            $response = $this->client->request(($method == 'form') ? 'POST' : $method, $url, $options);
            $data = json_decode($response->getBody());
  
            return $data;
        }
        catch (RequestException $e) {
            throw new OpenAIException($e->getMessage(), $e->getCode(), $e);
        }
    }
}
