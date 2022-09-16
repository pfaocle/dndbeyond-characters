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

test('valid current hit points', function ($base, $removed, $expected) {
    $this->character->setHitPoints($base, $removed);
    $this->assertEquals($this->character->currentHitPoints(), $expected);
})->with([
    [25, 0, 25],
    [25, 10, 15],
    [0, 0, 0],
    [0, 10, -10],
    [10000000000000, 0, 10000000000000],
    [10000000000000, 10000000000000, 0],
    [10000000000000, 9999999999999, 1],
]);

test('json array returns expected result', function () {
    $this->character->setHitPoints(25, 0);
    $ja = $this->character->jsonArray();

    $this->assertIsArray($ja);
    $this->assertEquals($ja, [
        'id' => 1234567,
        'name' => 'Sir Didymus',
        'raceclass' => 'Knight of Yore Fighter/Bard',
        'level' => 3,
        'campaign_id' => null,
        'campaign' => 'No campaign',
        'hp' => '25/25',
        'avatar' => 'default.png',
    ]);
});
