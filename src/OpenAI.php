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
     * The organization to use.
     */
    protected $organization;

    /**
     * The HTTP client.
     */
    protected $client;

    /**
     * OpenAI library constructor.
     * 
     * @param string $api_key the API key to use
     */
    public function __construct($api_key, $organization = null)
    {
        $this->api_key = $api_key;
        $this->organization = $organization;

        $this->client = new Client();
    }

    /**
     * Makes a request to the OpenAI API.
     *
     * @param string $method     the method to use when making the request
     *                           GET, POST or multipart
     * @param string $path       the API path to request
     * @param array  $parameters parameters to send with the request
     * @param array  $options    HTTP request options to send to Guzzle
     *
     * @return mixed
     *
     * @throws OpenAIException
     */
    public function request($method, $path, $parameters = [], $options = [])
    {
        // Set up authentication.
        $headers = ['Authorization' => 'Bearer ' . $this->api_key];

        // Set up optional organization.
        if ($this->organization !== null) {
            $headers['OpenAI-Organization'] = $this->organization;
        }

        $options['headers'] = $headers;

        if ($method == 'POST') {
            // POST parameters are included in the request body as JSON.
            $options['json'] = (object) $parameters;
        } else if ($method == 'multipart') {
            $options['multipart'] = $parameters;
        } else {
            // Request parameters are included in the query string for other methods.
            $options['query'] = $parameters;
        }
  
        try {
            $url = $this->endpoint.$path;
            $response = $this->client->request(($method == 'multipart') ? 'POST' : $method, $url, $options);

            if (isset($options['stream'])) {
                return $response->getBody()->getContents();
            } else {
                return json_decode($response->getBody());
            }
        }
        catch (RequestException $e) {
            if ($e->hasResponse()) {
                $response = $e->getResponse();
                $body = json_decode($response->getBody());
                throw new OpenAIException($body->error->message, $response->getStatusCode(), $e);
            }
            else {
                throw new OpenAIException($e->getMessage(), $e->getCode(), $e);
            }
        }
    }
}
