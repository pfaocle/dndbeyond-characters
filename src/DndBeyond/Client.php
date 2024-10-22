<?php

namespace Pfaocle\DndBeyondCharacters\DndBeyond;

use GuzzleHttp\Client as GuzzleClient;
use Psr\Http\Message\ResponseInterface;

class Client
{
    /**
     * The D&D Beyond public API base URL.
     */
    private const string BASE_URL = 'https://character-service.dndbeyond.com';

    /**
     * @var \GuzzleHttp\Client $client
     */
    protected $client;

    public function __construct()
    {
        $this->client = new GuzzleClient(['base_uri' => $this::BASE_URL]);
    }

    public function get(string $uri, array $options = []): ResponseInterface
    {
        return $this->client->get($uri, $options);
    }

    public function getCharacter(int $characterId): ResponseInterface
    {
        return $this->get('/character/v5/character/' . $characterId);
    }
}
