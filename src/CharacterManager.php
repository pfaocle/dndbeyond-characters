<?php

namespace Pfaocle\DndBeyondCharacters;

use Pfaocle\DndBeyondCharacters\DndBeyond\Client;

class CharacterManager
{
    /**
     * @var \Pfaocle\DndBeyondCharacters\DndBeyond\Client $client
     */
    protected $client;

    /**
     * @var array $originalIds
     */
    private $originalIds;

    /**
     * @var \Pfaocle\DndBeyondCharacters\Character[] $characters
     */
    protected $characters = [];

    /**
     * Construct a new list of characters based on  a list of character IDs.
     *
     * @param array $characterIds
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

    // Return a JSON representation of all characters.
    public function json(): string
    {
        return json_encode($this->list(), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }
}
