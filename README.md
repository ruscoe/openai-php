# PHP library for the OpenAI API

An unofficial library for OpenAI's API.

![release](https://img.shields.io/github/v/release/ruscoe/openai-php)

## Requirements

* PHP 8.1 or above
* [Composer](https://getcomposer.org)
* An [OpenAI API key](https://developers.openai.com/api/reference/overview#authentication)

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

This example asks the `gpt-4o` model to describe a computer keyboard.
It instructs the OpenAI API to use more than the default number of
tokens so a reasonable length description can be returned.

```php
<?php

require __DIR__ . '/vendor/autoload.php';

// @see https://developers.openai.com/api/reference/overview#authentication
$api_key = getenv('OPENAI_API_KEY');

$api = new OpenAI\OpenAICompletions($api_key);

$parameters = [
    'max_completion_tokens' => 128,
];

$messages = [
    (object) ['role' => 'user', 'content' => 'Briefly describe a computer keyboard']
];

$response = $api->create('gpt-4o', $messages, 1, $parameters);

var_dump($response->choices[0]->message->content);
```

The response:
```
string(648) "A computer keyboard is an input device used to enter text, numbers, and commands into a computer or other electronic devices. It is composed of an array of keys that includes the standard QWERTY layout for typing letters and numbers, along with various function keys, control keys, and special keys. Keyboards often feature additional keys or combinations for shortcuts and can vary in design, including wired or wireless models, ergonomic designs, and gaming keyboards with customizable keys and backlighting. They may also include a numeric keypad, arrow keys, and other keys like Escape, Tab, Caps Lock, Shift, Ctrl, Alt, and Enter, each serving"
```

### Chat

This example sends a simple chat message.

```php
<?php

require __DIR__ . '/vendor/autoload.php';

// @see https://developers.openai.com/api/reference/overview#authentication
$api_key = getenv('OPENAI_API_KEY');

$api = new OpenAI\OpenAIChat($api_key);

$messages = [
    (object) ['role' => 'user', 'content' => 'Hello, friend!'],
];

$response = $api->create('gpt-4o', $messages);

var_dump($response->choices[0]->message->content);
```

The response:
```
string(34) "Hello! How can I assist you today?"
```

### Images

**Create image**

This example asks for an image of a jungle waterfall.

```php
<?php

require __DIR__ . '/vendor/autoload.php';

// @see https://developers.openai.com/api/reference/overview#authentication
$api_key = getenv('OPENAI_API_KEY');

$api = new OpenAI\OpenAIImages($api_key);

$response = $api->createAsFile('gpt-image-2', 'A jungle waterfall', 'waterfall.png', 1, '1024x1024');
```

The response

![waterfall.png](samples/waterfall.png)

**Create image edit**

```php
<?php

require __DIR__ . '/vendor/autoload.php';

// @see https://developers.openai.com/api/reference/overview#authentication
$api_key = getenv('OPENAI_API_KEY');

$api = new OpenAI\OpenAIImages($api_key);

$response = $api->createEditAsFile('gpt-image-2', 'samples/car.png', 'a duck driving a car', 'edit.png', 'samples/car_mask.png', 1, '1024x1024');
```

The source and response:

![car.png](samples/car.png)
![car_mask.png](samples/car_mask.png)
![car_edit.png](samples/car_edit.png)

## Fine-tuning a model

First, take a look at the [official documentation on fine-tuning](https://developers.openai.com/api/docs/guides/supervised-fine-tuning).

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

// @see https://developers.openai.com/api/reference/overview#authentication
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
| OpenAIImages      | createAsFile            | Generates a number of images as files.                                      |
| OpenAIImages      | createAsBase64          | Generates a number of images and returns Base64 encoded image(s).           |
| OpenAIImages      | createEditAsFile        | Generates a number of image edits as files.                                 |
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
