<?php

namespace Pfaocle\DndBeyondCharacters;

use Exception;

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

        $character = new Character(
            $json->id,
            $json->name
        );

        $character->setHitPoints($json->baseHitPoints, $json->removedHitPoints);
        $character->setRace($json->race->fullName);

        // Classes and level.
        $level = 0;
        $classes = [];
        foreach ($json->classes as $class) {
            $level += $class->level;
            $classes[] = $class->definition->name;
        }
        $character->setLevel($level);
        $character->setClasses($classes);

        $character->setCampaign($json->campaign ? $json->campaign->name : 'No campaign');

        if ($json->decorations->avatarUrl) {
            $character->setAvatar($json->decorations->avatarUrl);
        }

        return $character;
    }
}
