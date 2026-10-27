<?php

declare(strict_types=1);

namespace Pfaocle\DndBeyondCharacters\DndBeyond;

use GuzzleHttp\Client as GuzzleClient;
use Psr\Http\Message\ResponseInterface;

final class Client
{
    /**
     * The D&D Beyond public API base URL.
     */
    private const string BASE_URL = 'https://character-service.dndbeyond.com';

    protected GuzzleClient $client;

    public function __construct(?GuzzleClient $client = null)
    {
        $this->client = $client ?? new GuzzleClient(['base_uri' => self::BASE_URL]);
    }

    /**
     * @param array<string, mixed> $options
     */
    public function get(string $uri, array $options = []): ResponseInterface
    {
        return $this->client->get($uri, $options);
    }

    public function getCharacter(int $characterId): ResponseInterface
    {
        return $this->get('/character/v5/character/' . $characterId);
    }
}
