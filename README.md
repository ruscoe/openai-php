# PHP library for the OpenAI API

## Supported methods

### Models

* `/models` - get a list of OpenAI models
* `/models/{model}` - get a specific openAI model

### Completions

* `/completions` - create a new completion

### Edits

* `/edits` - create an edit for a given input

## Requirements

* PHP 5.4.0 or above
* [Composer](https://getcomposer.org)
* An [OpenAI API key](https://platform.openai.com/docs/api-reference/authentication)

## Quick set up

`git clone git@github.com:ruscoe/openai-php.git`

`cd openai-php`

`composer install`

## Usage example

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
    'prompt' => 'Describe a keyboard',
];

$response = $api->create('text-davinci-003', $parameters);

var_dump($response);
```

The trimmed response:
```
object(stdClass)#34 (6) {
  ["model"]=>
  string(16) "text-davinci-003"
  ["choices"]=>
  array(1) {
    [0]=>
    object(stdClass)#32 (4) {
      ["text"]=>
      string(320) "
A keyboard is a peripheral device used to operate a computer or other electronic machines.
It typically consists of alphanumeric and other keys that make use of electronic signals
to cause a certain action on the system. It often has trackpoint or a touchpad that
allows users to control the cursor on the computer."
    }
  }
}
```

## License

[MIT](https://mit-license.org)
