<?php

namespace Pfaocle\DndBeyondCharacters\DndBeyond;

final class Rules
{
    public static function abilityScoreToModifier(int $abilityScore): int
    {
        return (int) floor(($abilityScore - 10) / 2);
    }
}
