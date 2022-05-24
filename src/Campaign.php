<?php

namespace Pfaocle\DndBeyondCharacters;

class Campaign
{
    protected const CAMPAIGN_PATH_PATTERN = '/campaigns/%d';

    protected int $id;
    protected string $name;

    public function __construct(int $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function path(): string
    {
        return sprintf($this::CAMPAIGN_PATH_PATTERN, $this->id);
    }
}
