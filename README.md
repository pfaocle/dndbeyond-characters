D&D Beyond Characters
===

![Build](https://github.com/pfaocle/dndbeyond-characters/actions/workflows/php.yml/badge.svg)

A small utility to grab D&D characters from the D&D Beyond public API.

## Dependencies

- PHP >=8.3
- [guzzlehhttp/guzzle](https://github.com/guzzlehttp/guzzle/)


## Install

Install with Composer:

```sh
composer require pfaocle/dndbeyond-characters
```


## Usage

### With Jigsaw

This utility can be used to populate a collection on a [Jigsaw] site. First, create
an [Event Listener] in your Jigsaw application:

```php
<?php

namespace App\Listeners;

use Pfaocle\DndBeyondCharacters\CharacterManager;
use TightenCo\Jigsaw\Jigsaw;

class GenerateCharacters
{
    public function handle(Jigsaw $jigsaw)
    {
        // Replace these IDs with those of your characters.
        $characters = new CharacterManager([
            12345678,
            23456789,
        ]);

        file_put_contents(
            $jigsaw->getConfig('characterStore'),
            $characters->json()
        );
    }
}
```

and register it in `bootstrap.php`:

```php
$events->beforeBuild(App\Listeners\GenerateCharacters::class);
```

This will create a `characters.json` in your Jigsaw repository root when building
the site.

Next, create a [Remote Collection] in your Jigsaw site's `config.php`, for example:

```php
return [
    ...
    'characterStore' => 'characters.json',

    'collections' => [
        'posts' => [
            'path' => 'blog/{filename}',
        ],
        'characters' => [
            'items' => function ($config) {
                $characters = json_decode(file_get_contents($config['characterStore']));

                return collect($characters)->map(function ($character) {
                    return [
                        'name' => $character->name,
                        'raceclass' => $character->raceclass,
                        'level' => $character->level,
                        'campaign_id' => $character->campaign_id,
                        'campaign' => $character->campaign,
                        'hp' => $character->hp,
                        'avatar' => $character->avatar,
                    ];
                });
            },
        ],
    ],

    ...
```


### Standalone

Copy the `config.example.php` file to `config.php` and amend the `$characters` array
to include the IDs of the characters you wish to include. Running

```
php ./app.php
```

will then output a simple JSON representation of those characters.


## Tests

```
./vendor/bin/pest
./vendor/bin/grumphp run
./vendor/bin/phpcs --standard=PSR12 src app.php
./vendor/bin/psalm --show-info=true
```

[Jigsaw]: https://jigsaw.tighten.com/
[Event Listener]: https://jigsaw.tighten.com/docs/event-listeners/
[Remote Collection]: https://jigsaw.tighten.com/docs/collections-remote-collections/
