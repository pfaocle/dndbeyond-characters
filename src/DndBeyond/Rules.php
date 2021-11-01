<?php

namespace Pfaocle\DndBeyondCharacters\DndBeyond;

class Rules
{
    public static function abilityScoreToModifier(int $abilityScore): int
    {
        return floor(($abilityScore - 10) / 2);
    }
}
