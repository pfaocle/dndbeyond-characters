<?php

namespace Pfaocle\DndBeyondCharacters;

use Pfaocle\DndBeyondCharacters\DndBeyond\Site;

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

    public function publicUrl($base_url = ''): string
    {
        if ($base_url === '') {
            $base_url = Site::DND_BEYOND_SITE_BASE_URL;
        }
        return  $base_url . $this->path();
    }
}
