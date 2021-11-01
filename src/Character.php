<?php

namespace Pfaocle\DndBeyondCharacters;

class Character
{
    protected $id;
    protected string $name;
    protected int $baseHitPoints;
    protected int $removedHitPoints = 0;
    protected string $race;
    protected int $level = 1;
    protected array $classes = [];
    protected int $conModifier = 0;
    protected string $campaign = 'No campaign';
    protected string $avatar = 'default.png';

    public function __construct(int $characterId, string $name, string $race, int $level, array $classes = [])
    {
        $this->id = $characterId;
        $this->name = $name;
        $this->race = $race;
        $this->level = $level;
        $this->classes = $classes;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function maxHitPoints(): int
    {
        return $this->baseHitPoints + ($this->conModifier * $this->level);
    }

    public function currentHitPoints(): int
    {
        return $this->maxHitPoints() - $this->removedHitPoints;
    }

    public function setHitPoints(int $base, int $removed): void
    {
        $this->baseHitPoints = $base;
        $this->removedHitPoints = $removed;
    }

    public function race(): string
    {
        return $this->race;
    }

    public function setRace(string $race): void
    {
        $this->race = $race;
    }

    public function level(): int
    {
        return $this->level;
    }

    public function setLevel(int $level): void
    {
        $this->level = $level;
    }

    public function setConModifier(int $modifier): void
    {
        $this->conModifier = $modifier;
    }

    public function class(): string
    {
        return implode('/', $this->classes);
    }

    public function setClasses(array $classes): void
    {
        $this->classes = $classes;
    }

    public function campaign(): string
    {
        return $this->campaign;
    }

    public function setCampaign(string $campaign): void
    {
        $this->campaign = $campaign;
    }

    public function avatar(): string
    {
        return $this->avatar;
    }

    public function setAvatar(string $url): void
    {
        $this->avatar = $url;
    }

    /**
     * Return an array representing the character that can be used for JSON output.
     *
     * @return array
     */
    public function jsonArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'raceclass' => sprintf("%s %s", $this->race, $this->class()),
            'level' => $this->level,
            'campaign' => $this->campaign,
            'hp' => sprintf("%d/%d", $this->currentHitPoints(), $this->maxHitPoints()),
            'avatar' => $this->avatar,
        ];
    }
}
