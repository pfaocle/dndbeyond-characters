<?php

namespace Pfaocle\DndBeyondCharacters;

use Exception;
use Pfaocle\DndBeyondCharacters\DndBeyond\Rules;

class CharacterFactory
{
    /**
     * @param object $json
     *   The character data as JSON object.
     *
     * @return \Pfaocle\DndBeyondCharacters\Character
     */
    public static function createFromJson(object $json): Character
    {
        if (!isset($json->id)) {
            throw new Exception('No character ID found in JSON.');
        }

        // Classes and level.
        $level = 0;
        $classes = [];
        foreach ($json->classes as $class) {
            $level += $class->level;
            $classes[] = $class->definition->name;
        }

        $character = new Character(
            $json->id,
            $json->name,
            $json->race->fullName,
            $level,
            $classes
        );

        $base_con = $json->stats[2]->value;
        // @todo Get any con bonuses...
        $con = $base_con + 3;
        $character->setConModifier(Rules::abilityScoreToModifier($con));

        $character->setHitPoints(
            $json->baseHitPoints,
            $json->removedHitPoints
        );

        if ($json->campaign) {
            $character->setCampaign($json->campaign->name);
        }

        if ($json->decorations->avatarUrl) {
            $character->setAvatar($json->decorations->avatarUrl);
        }

        return $character;
    }
}
