<?php

namespace Pfaocle\DndBeyondCharacters\DndBeyond;

class Rules
{
    public static function abilityScoreToModifier(int $abilityScore): int
    {
        return (int) floor(($abilityScore - 10) / 2);
    }
}
