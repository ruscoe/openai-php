# PHP library for the OpenAI API

## Requirements

* PHP 5.4.0 or above
* [Composer](https://getcomposer.org)
* An [OpenAI API key](https://platform.openai.com/docs/api-reference/authentication)

## Quick set up

`git clone git@github.com:ruscoe/openai-php.git`
`cd openai-php`
`composer install`

## Usage example

In a PHP file:

```php
<?php

require 'PATH_TO_LIBRARY/vendor/autoload.php';

// @see https://platform.openai.com/docs/api-reference/authentication
$api_key = 'YOUR API KEY';

$api = new OpenAI\OpenAIModels($api_key);

$models = $api->getModels();

var_dump($models);
```
