# PHP library for the OpenAI API

## Supported methods

### Models

* `/models` - get a list of OpenAI models
* `/models/{model}` - get a specific openAI model

### Completions

* `/completions` - create a new completion

### Edits

* `/edits` - create an edit for a given input

### Images

* `/images/generations` - create images

## Requirements

* PHP 5.4.0 or above
* [Composer](https://getcomposer.org)
* An [OpenAI API key](https://platform.openai.com/docs/api-reference/authentication)

## Quick set up

`git clone git@github.com:ruscoe/openai-php.git`

`cd openai-php`

`composer install`

## Usage examples

### Completions

This example asks the `text-davinci-003` model to describe a keyboard.
It instructs the OpenAI API to use more than the default number of
tokens so a reasonable length description can be returned.

```php
<?php

require 'PATH TO LIBRARY/vendor/autoload.php';

// @see https://platform.openai.com/docs/api-reference/authentication
$api_key = 'YOUR API KEY';

$api = new OpenAI\OpenAICompletions($api_key);

$parameters = [
    'max_tokens' => 64,
];

$response = $api->create('text-davinci-003', 'Describe a keyboard', 1, $parameters);

var_dump($response);
```

The response:
```
array(1) {
  [0]=>
  object(stdClass)#32 (4) {
    ["text"]=>
    string(282) "

A keyboard is a peripheral device that can be connected to a computer to provide an easier way to enter data. A standard keyboard usually consists of alphanumeric keys which can be used to type words and numbers, as well as a number of special keys for performing various functions."
    ["index"]=>
    int(0)
    ["logprobs"]=>
    NULL
    ["finish_reason"]=>
    string(6) "length"
  }
}

```

### Images

This example asks for two images of a red six-sided dice in water.

```php
$api = new OpenAI\OpenAIImages($api_key);

$response = $api->createAsURL('A red six-sided dice in water', 2, '256x256');
```

The response

![img-En2d68xA9UIv6jLatSjEuonV](https://user-images.githubusercontent.com/87952/234153728-f996cf8d-46d8-4353-9d79-4eb643615ccc.png)
![img-Tt54f3mLG0SpP6EPwgbe7zr5](https://user-images.githubusercontent.com/87952/234153737-8630f37e-e1ff-42de-916a-2d1dff21f51f.png)

## License

[MIT](https://mit-license.org)
