# PHP library for the OpenAI API

An unofficial library for OpenAI's API.

![release](https://img.shields.io/github/v/release/ruscoe/openai-php)

## Requirements

* PHP 8.1 or above
* [Composer](https://getcomposer.org)
* An [OpenAI API key](https://platform.openai.com/docs/api-reference/authentication)

## Quick set up

`git clone git@github.com:ruscoe/openai-php.git`

`cd openai-php`

`composer install`

## Usage examples

The following examples assume you store your API key in an environment variable.
To do this on a Linux or MacOS system, run:

`export OPENAI_API_KEY=sk-XA0yN...`

Be sure to substitute your own API key after `OPENAI_API_KEY=`.

### Completions

This example asks the `gpt-3.5-turbo` model to describe a keyboard.
It instructs the OpenAI API to use more than the default number of
tokens so a reasonable length description can be returned.

```php
<?php

require __DIR__ . '/vendor/autoload.php';

// @see https://platform.openai.com/docs/api-reference/authentication
$api_key = getenv('OPENAI_API_KEY');

$api = new OpenAI\OpenAICompletions($api_key);

$parameters = [
    'max_tokens' => 128,
];

$response = $api->create('gpt-3.5-turbo', 'Describe a keyboard', 1, $parameters);

var_dump($response);
```

The response:
```
object(stdClass)#34 (6) {
  ["id"]=>
  string(34) "cmpl-7EqnVAO0xpxtWkDepi2s64AG7UAbU"
  ["object"]=>
  string(15) "text_completion"
  ["created"]=>
  int(1683773901)
  ["model"]=>
  string(16) "gpt-3.5-turbo"
  ["choices"]=>
  array(1) {
    [0]=>
    object(stdClass)#32 (4) {
      ["text"]=>
      string(663) "

A keyboard is a computer peripheral device used for entering data and commands into a computer or other device. It consists of a keypad, usually a set of standard-sized keys corresponding to letters, numbers, symbols, and/or functionality, which can be powered by various means including electricity, batteries, or solar cells. It generally has several special-function keys that can be used to control program functions, such as volume or brightness levels. Modern keyboards often include multimedia hotkeys, and are typically back-lit in order to make typing in the dark easier. Some keyboards may include a palm rest to help reduce fatigue caused by extended"
      ["index"]=>
      int(0)
      ["logprobs"]=>
      NULL
      ["finish_reason"]=>
      string(6) "length"
    }
  }
  ["usage"]=>
  object(stdClass)#18 (3) {
    ["prompt_tokens"]=>
    int(4)
    ["completion_tokens"]=>
    int(128)
    ["total_tokens"]=>
    int(132)
  }
}
```

### Chat

This example sends a simple chat message.

```php
<?php

require __DIR__ . '/vendor/autoload.php';

// @see https://platform.openai.com/docs/api-reference/authentication
$api_key = getenv('OPENAI_API_KEY');

$api = new OpenAI\OpenAIChat($api_key);

$messages = [
    (object) ['role' => 'user', 'content' => 'Hello, friend!'],
];

$response = $api->create('gpt-3.5-turbo', $messages);

var_dump($response);
```

The response:
```
object(stdClass)#35 (6) {
  ["id"]=>
  string(38) "chatcmpl-7EqphlIJngrqxGAiDdtV9JMu89NhQ"
  ["object"]=>
  string(15) "chat.completion"
  ["created"]=>
  int(1683774037)
  ["model"]=>
  string(18) "gpt-3.5-turbo-0301"
  ["usage"]=>
  object(stdClass)#33 (3) {
    ["prompt_tokens"]=>
    int(12)
    ["completion_tokens"]=>
    int(10)
    ["total_tokens"]=>
    int(22)
  }
  ["choices"]=>
  array(1) {
    [0]=>
    object(stdClass)#29 (3) {
      ["message"]=>
      object(stdClass)#19 (2) {
        ["role"]=>
        string(9) "assistant"
        ["content"]=>
        string(40) "Hello there, how may I assist you today?"
      }
      ["finish_reason"]=>
      string(4) "stop"
      ["index"]=>
      int(0)
    }
  }
}
```

### Images

**Create image**

This example asks for two images of a red six-sided dice in water.

```php
<?php

require __DIR__ . '/vendor/autoload.php';

// @see https://platform.openai.com/docs/api-reference/authentication
$api_key = getenv('OPENAI_API_KEY');

$api = new OpenAI\OpenAIImages($api_key);

$response = $api->createAsURL('A red six-sided dice in water', 2, '256x256');
```

The response

![img-OFmHrZWgvmnGmizogrqP5SGv](https://user-images.githubusercontent.com/87952/234959056-0c86d4ae-175c-49d5-b8ea-ca0e49a94186.png)
![img-9O0Nv8GCurUr86pzzkv4dlJE](https://user-images.githubusercontent.com/87952/234959077-882399fc-bb9a-4479-b8ea-722e89c6acf3.png)

**Create image variation**

```php
<?php

require __DIR__ . '/vendor/autoload.php';

// @see https://platform.openai.com/docs/api-reference/authentication
$api_key = getenv('OPENAI_API_KEY');

$api = new OpenAI\OpenAIImages($api_key);

$response = $api->createVariationAsURL('variation.png', 1, '256x256');
```

The source and response

![variation](https://user-images.githubusercontent.com/87952/234940408-4beec8a3-6a8b-44bd-b9d1-fda9a8a98c6e.png)
![variation1](https://user-images.githubusercontent.com/87952/234940430-408e14c5-a338-49f7-918f-a3eee632dc1d.png)

**Create image edit**

```php
<?php

require __DIR__ . '/vendor/autoload.php';

// @see https://platform.openai.com/docs/api-reference/authentication
$api_key = getenv('OPENAI_API_KEY');

$api = new OpenAI\OpenAIImages($api_key);

$response = $api->createEditAsURL('edit.png', 'a duck driving a car', 'edit_mask.png', 1, '256x256');
```

The source and response

![edit](https://user-images.githubusercontent.com/87952/234949655-8d055b40-e668-4e38-8c35-e6823c4fa047.png)
![edit_mask](https://user-images.githubusercontent.com/87952/234949679-624f6ee2-1e15-487a-9332-3bad136343ca.png)
![edit1](https://user-images.githubusercontent.com/87952/234949702-566aa1d7-f7c1-4788-b1c7-8b2b7bbcf468.png)

## Fine-tuning a model

First, take a look at the [official documentation on fine-tuning](https://platform.openai.com/docs/guides/fine-tuning).

Create and upload your training file. Example:

**training.jsonl**
```
{"prompt": "bird =", "completion": " animal"}
{"prompt": "dog =", "completion": " animal"}
{"prompt": "cat =", "completion": " animal"}
{"prompt": "limestone =", "completion": " rock"}
{"prompt": "shale =", "completion": " rock"}
{"prompt": "marble =", "completion": " rock"}
```

```php
<?php

require __DIR__ . '/vendor/autoload.php';

// @see https://platform.openai.com/docs/api-reference/authentication
$api_key = getenv('OPENAI_API_KEY');

$api = new OpenAI\OpenAIFiles($api_key);

$file = $api->uploadFile('training.jsonl');
```

List your files to get the file ID:

```php
$api = new OpenAI\OpenAIFiles($api_key);

$files = $api->getFiles();

var_dump($files);
```

Create a new training job using the file ID you've obtained:

```php
$api = new OpenAI\OpenAIFineTunes($api_key);

$api->create('file-1CO...');
```

List models to get the name of your new fine-tuned model:

```php
$api = new OpenAI\OpenAIModels($api_key);

$models = $api->getModels();

var_dump($models);
```

The model name will start with `curie:ft` and end with the current date and time.

Create a new completion using your fine-tuned model.

```php
$api = new OpenAI\OpenAICompletions($api_key);

$response = $api->create('curie:ft...', 'dog =', 1, $parameters);
```

The response should include "animal".

```php
$api = new OpenAI\OpenAICompletions($api_key);

$response = $api->create('curie:ft...', 'marble =', 1, $parameters);
```

The response should include "rock".


## Available functions

### Models

| Class             | Function                | Description                                                                 |
|-------------------|-------------------------|-----------------------------------------------------------------------------|
| OpenAIModels      | getModels               | Gets available OpenAI models.                                               |
| OpenAIModels      | getModel                | Gets a specific OpenAI model.                                               |

### Completions

| Class             | Function                | Description                                                                 |
|-------------------|-------------------------|-----------------------------------------------------------------------------|
| OpenAICompletions | create                  | Creates one or more completions from a given input.                         |

### Chat

| Class             | Function                | Description                                                                 |
|-------------------|-------------------------|-----------------------------------------------------------------------------|
| OpenAIChat        | create                  | Creates one or more completions from a chat conversation.                   |

### Edits

| Class             | Function                | Description                                                                 |
|-------------------|-------------------------|-----------------------------------------------------------------------------|
| OpenAIEdits       | create                  | Performs an edit on a given input.                                          |

### Images

| Class             | Function                | Description                                                                 |
|-------------------|-------------------------|-----------------------------------------------------------------------------|
| OpenAIImages      | createAsURL             | Generates a number of images and returns URLs.                              |
| OpenAIImages      | createAsBase64          | Generates a number of images and returns Base64 encoded image(s).           |
| OpenAIImages      | createVariationAsURL    | Generates a number of image variations and returns URL(s).                  |
| OpenAIImages      | createVariationAsBase64 | Generates a number of image variations and returns Base64 encoded image(s). |
| OpenAIImages      | createVariation         | Generates a number of image variations from a given image.                  |
| OpenAIImages      | createEditAsURL         | Generates a number of image edits and returns URL(s).                       |
| OpenAIImages      | createEditAsBase64      | Generates a number of image edits and returns Base64 encoded image(s).      |
| OpenAIImages      | createEdit              | Generates a number of image edits from a given image.                       |

### Embeddings

| Class             | Function                | Description                                                                 |
|-------------------|-------------------------|-----------------------------------------------------------------------------|
| OpenAIEmbeddings  | create                  | Creates an embedding vector from given input.                               |

### Audio

| Class             | Function                | Description                                                                 |
|-------------------|-------------------------|-----------------------------------------------------------------------------|
| OpenAIAudio       | transcribe              | Transcribes text from an audio file.                                        |

### Files

| Class             | Function                | Description                                                                 |
|-------------------|-------------------------|-----------------------------------------------------------------------------|
| OpenAIFiles       | getFiles                | Gets files owned by the user's organization.                                |
| OpenAIFiles       | uploadFile              | Uploads a file.                                                             |
| OpenAIFiles       | deleteFile              | Deletes a file.                                                             |
| OpenAIFiles       | getFile                 | Gets information about a file.                                              |
| OpenAIFiles       | getFileContent          | Gets the content of a file.                                                 |

### Fine-Tunes

| Class             | Function                | Description                                                                 |
|-------------------|-------------------------|-----------------------------------------------------------------------------|
| OpenAIFineTunes   | create                  | Creates a fine-tune job.                                                    |
| OpenAIFineTunes   | getFineTunes            | Gets existing fine-tunes.                                                   |
| OpenAIFineTunes   | cancelFineTune          | Cancels a fine-tune job.                                                    |
| OpenAIFineTunes   | getFineTuneEvents       | Gets status updates of a fine-tune job.                                     |
| OpenAIFineTunes   | deleteModel             | Deletes a fine-tuned model.                                                 |

### Moderations

| Class             | Function                | Description                                                                 |
|-------------------|-------------------------|-----------------------------------------------------------------------------|
| OpenAIModerations | create                  | Requests a moderation result from OpenAI.                                   |

## License

[MIT](https://mit-license.org)
