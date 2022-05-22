<?php

use Pfaocle\DndBeyondCharacters\Character;

beforeeach(function () {
    $this->character = new Character(
        1234567,
        'Sir Didymus',
        'Knight of Yore',
        3,
        ['Fighter', 'Bard']
    );
});

test('create a character object', function () {
    $this->assertTrue($this->character instanceof Character);
    $this->assertEquals($this->character->id(), 1234567);
    $this->assertEquals($this->character->name(), 'Sir Didymus');
    $this->assertEquals($this->character->race(), 'Knight of Yore');
    $this->assertEquals($this->character->level(), 3);
    $this->assertEquals($this->character->class(), 'Fighter/Bard');
});
