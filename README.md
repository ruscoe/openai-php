# PHP library for the OpenAI API

An unofficial library for OpenAI's API.

![release](https://img.shields.io/github/v/release/ruscoe/openai-php)

## Used by

[DrupalGen](https://github.com/ruscoe/drupalgen) - ChatGPT content generation for Drupal.

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

This example asks the `gpt-4o` model to describe a keyboard.
It instructs the OpenAI API to use more than the default number of
tokens so a reasonable length description can be returned.

```php
<?php

require __DIR__ . '/vendor/autoload.php';

// @see https://platform.openai.com/docs/api-reference/authentication
$api_key = getenv('OPENAI_API_KEY');

$api = new OpenAI\OpenAICompletions($api_key);

$parameters = [
    'max_completion_tokens' => 128,
];

$messages = [
    (object) ['role' => 'user', 'content' => 'Describe a keyboard']
];

$response = $api->create('gpt-4o', $messages, 1, $parameters);

var_dump($response);
```

The response:
```
object(stdClass)#35 (8) {
  ["id"]=>
  string(38) "chatcmpl-BLXYoMfybsQQjP1xlKjUtEL6chvHE"
  ["object"]=>
  string(15) "chat.completion"
  ["created"]=>
  int(1744473594)
  ["model"]=>
  string(17) "gpt-4o-2024-08-06"
  ["choices"]=>
  array(1) {
    [0]=>
    object(stdClass)#33 (4) {
      ["index"]=>
      int(0)
      ["message"]=>
      object(stdClass)#19 (4) {
        ["role"]=>
        string(9) "assistant"
        ["content"]=>
        string(604) "A keyboard is an input device used primarily to input text and commands into a computer or other electronic devices. Here are some key features and components of a typical keyboard:

1. **Keys**: A standard keyboard contains a variety of keys, each with a specific function. These include:
   - **Alphanumeric keys**: These are similar to those on a typewriter and include letters (A-Z), numbers (0-9), and punctuation symbols.
   - **Function keys**: Usually labeled F1 through F12, these keys are located at the top of the keyboard and offer shortcuts for various system and application functions.
   -"
        ["refusal"]=>
        NULL
        ["annotations"]=>
        array(0) {
        }
      }
      ["logprobs"]=>
      NULL
      ["finish_reason"]=>
      string(6) "length"
    }
  }
  ["usage"]=>
  object(stdClass)#29 (5) {
    ["prompt_tokens"]=>
    int(10)
    ["completion_tokens"]=>
    int(128)
    ["total_tokens"]=>
    int(138)
    ["prompt_tokens_details"]=>
    object(stdClass)#22 (2) {
      ["cached_tokens"]=>
      int(0)
      ["audio_tokens"]=>
      int(0)
    }
    ["completion_tokens_details"]=>
    object(stdClass)#20 (4) {
      ["reasoning_tokens"]=>
      int(0)
      ["audio_tokens"]=>
      int(0)
      ["accepted_prediction_tokens"]=>
      int(0)
      ["rejected_prediction_tokens"]=>
      int(0)
    }
  }
  ["service_tier"]=>
  string(7) "default"
  ["system_fingerprint"]=>
  string(13) "fp_b7faba9ef5"
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

$response = $api->create('gpt-4o', $messages);

var_dump($response);
```

The response:
```
object(stdClass)#35 (8) {
  ["id"]=>
  string(38) "chatcmpl-BLXdCiHRU78QMKpj9q7D36Kb6UIVg"
  ["object"]=>
  string(15) "chat.completion"
  ["created"]=>
  int(1744473866)
  ["model"]=>
  string(17) "gpt-4o-2024-08-06"
  ["choices"]=>
  array(1) {
    [0]=>
    object(stdClass)#33 (4) {
      ["index"]=>
      int(0)
      ["message"]=>
      object(stdClass)#19 (4) {
        ["role"]=>
        string(9) "assistant"
        ["content"]=>
        string(34) "Hello! How can I assist you today?"
        ["refusal"]=>
        NULL
        ["annotations"]=>
        array(0) {
        }
      }
      ["logprobs"]=>
      NULL
      ["finish_reason"]=>
      string(4) "stop"
    }
  }
  ["usage"]=>
  object(stdClass)#29 (5) {
    ["prompt_tokens"]=>
    int(11)
    ["completion_tokens"]=>
    int(10)
    ["total_tokens"]=>
    int(21)
    ["prompt_tokens_details"]=>
    object(stdClass)#22 (2) {
      ["cached_tokens"]=>
      int(0)
      ["audio_tokens"]=>
      int(0)
    }
    ["completion_tokens_details"]=>
    object(stdClass)#20 (4) {
      ["reasoning_tokens"]=>
      int(0)
      ["audio_tokens"]=>
      int(0)
      ["accepted_prediction_tokens"]=>
      int(0)
      ["rejected_prediction_tokens"]=>
      int(0)
    }
  }
  ["service_tier"]=>
  string(7) "default"
  ["system_fingerprint"]=>
  string(13) "fp_b7faba9ef5"
```

### Images

**Create image**

This example asks for two images of a jungle waterfall.

```php
<?php

require __DIR__ . '/vendor/autoload.php';

// @see https://platform.openai.com/docs/api-reference/authentication
$api_key = getenv('OPENAI_API_KEY');

$api = new OpenAI\OpenAIImages($api_key);

$response = $api->createAsURL('A jungle waterfall', 2, '256x256');

var_dump($response);
```

The response

![img-idDF5Pwt0q3X35QNJ65zJl0s](https://github.com/user-attachments/assets/9171b6e1-f90e-4bbd-a8a0-41808bbc795f)
![img-Idq18QuOHuNE5us729mOKa2P](https://github.com/user-attachments/assets/d3db197d-6fdb-40c6-b16a-e214c08f9932)

**Create image variation**

```php
<?php

require __DIR__ . '/vendor/autoload.php';

// @see https://platform.openai.com/docs/api-reference/authentication
$api_key = getenv('OPENAI_API_KEY');

$api = new OpenAI\OpenAIImages($api_key);

$response = $api->createVariationAsURL('variation.png', 1, '256x256');

var_dump($response);
```

The source and response

![variation](https://user-images.githubusercontent.com/87952/234940408-4beec8a3-6a8b-44bd-b9d1-fda9a8a98c6e.png)
![img-ARP7fJQMVNwHsz1fVkKnCudb](https://github.com/user-attachments/assets/762e36a0-7c05-4743-9581-e6ca397b5a22)

**Create image edit**

```php
<?php

require __DIR__ . '/vendor/autoload.php';

// @see https://platform.openai.com/docs/api-reference/authentication
$api_key = getenv('OPENAI_API_KEY');

$api = new OpenAI\OpenAIImages($api_key);

$response = $api->createEditAsURL('edit.png', 'a duck driving a car', 'edit_mask.png', 1, '256x256');

var_dump($response);
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
{"messages": [{"role": "system", "content": "A chatbot that knows the difference between animals and rocks."}, {"role": "user", "content": "What is a dog?"}, {"role": "assistant", "content": "A dog is an animal."}]}
{"messages": [{"role": "system", "content": "A chatbot that knows the difference between animals and rocks."}, {"role": "user", "content": "What is a cat?"}, {"role": "assistant", "content": "A cat is an animal."}]}
{"messages": [{"role": "system", "content": "A chatbot that knows the difference between animals and rocks."}, {"role": "user", "content": "What is a bird?"}, {"role": "assistant", "content": "A bird is an animal."}]}
{"messages": [{"role": "system", "content": "A chatbot that knows the difference between animals and rocks."}, {"role": "user", "content": "What is a dolphin?"}, {"role": "assistant", "content": "A dolphin is an animal."}]}
{"messages": [{"role": "system", "content": "A chatbot that knows the difference between animals and rocks."}, {"role": "user", "content": "What is a lion?"}, {"role": "assistant", "content": "A lion is an animal."}]}
{"messages": [{"role": "system", "content": "A chatbot that knows the difference between animals and rocks."}, {"role": "user", "content": "What is limestone?"}, {"role": "assistant", "content": "Limestone is a rock."}]}
{"messages": [{"role": "system", "content": "A chatbot that knows the difference between animals and rocks."}, {"role": "user", "content": "What is marble?"}, {"role": "assistant", "content": "Marble is a rock."}]}
{"messages": [{"role": "system", "content": "A chatbot that knows the difference between animals and rocks."}, {"role": "user", "content": "What is granite?"}, {"role": "assistant", "content": "Granite is a rock."}]}
{"messages": [{"role": "system", "content": "A chatbot that knows the difference between animals and rocks."}, {"role": "user", "content": "What is shale?"}, {"role": "assistant", "content": "Shale is a rock."}]}
{"messages": [{"role": "system", "content": "A chatbot that knows the difference between animals and rocks."}, {"role": "user", "content": "What is basalt?"}, {"role": "assistant", "content": "Basalt is a rock."}]}
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

$api->create('gpt-4o-mini-2024-07-18', 'file-mQy...');
```

Fine-tuning can take a while. Check the [Fine-tuning UI](https://platform.openai.com/finetune/) for updates.

List models to get the name of your new fine-tuned model:

```php
$api = new OpenAI\OpenAIModels($api_key);

$models = $api->getModels();

var_dump($models);
```

The model name will look something like this: `ft:gpt-4o-mini-2024-07-18:personal::ABCABC`

Create a new completion using your fine-tuned model.

```php
$api = new OpenAI\OpenAICompletions($api_key);

$messages = [
    (object) ['role' => 'user', 'content' => 'What is a dog?'],
];

$response = $api->create('ft:gpt-4o-mini-2024-07-18:personal::ABCABC', $messages);

var_dump($response);
```

The response should be "A dog is an animal."

```php
$api = new OpenAI\OpenAICompletions($api_key);

$messages = [
    (object) ['role' => 'user', 'content' => 'What is marble?'],
];

$response = $api->create('ft:gpt-4o-mini-2024-07-18:personal::ABCABC', $messages);

var_dump($response);
```

The response should be "Marble is a rock."


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
