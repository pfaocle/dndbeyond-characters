<?php

declare(strict_types=1);

namespace Pfaocle\DndBeyondCharacters;

use Pfaocle\DndBeyondCharacters\DndBeyond\Client;

final class CharacterManager
{
    /**
     * @var \Pfaocle\DndBeyondCharacters\DndBeyond\Client
     */
    protected Client $client;

    /**
     * @var int[]
     */
    private array $originalIds;

    /**
     * @var \Pfaocle\DndBeyondCharacters\Character[]
     */
    protected array $characters = [];

    /**
     * Construct a new list of characters based on a list of character IDs.
     *
     * @param int[]|array<int> $characterIds
     */
    public function __construct(array $characterIds)
    {
        $this->client = new Client();
        $this->originalIds = $characterIds;
        $this->fetch();
    }

    /**
     * Fetch all data and store array of Characters.
     */
    public function fetch(): void
    {
        if (empty($this->originalIds)) {
            return;
        }

        foreach ($this->originalIds as $id) {
            $response = $this->client->getCharacter($id);
            if ($response->getStatusCode() === 200) {
                $characterData = json_decode((string) $response->getBody());
                $this->characters[] = CharacterFactory::createFromJson($characterData->data);
            }
        }
    }

    /**
     * @return \Pfaocle\DndBeyondCharacters\Character[]
     */
    public function characters(): array
    {
        return $this->characters;
    }

    public function list(): array
    {
        $out = [];
        foreach ($this->characters() as $character) {
            $out[] = $character->jsonArray();
        }
        return $out;
    }

    /**
     * Return a JSON representation of all characters.
     */
    public function json(): string|false
    {
        return json_encode($this->list(), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }
}
