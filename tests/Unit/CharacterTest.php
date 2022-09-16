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
    expect($this->character instanceof Character)->toBeTrue();
    expect($this->character->id())->toBe(1234567);
    expect($this->character->name())->toBe('Sir Didymus');
    expect($this->character->race())->toBe('Knight of Yore');
    expect($this->character->level())->toBe(3);
    expect($this->character->class())->toBe('Fighter/Bard');
});

test('valid current hit points', function ($base, $removed, $expected) {
    $this->character->setHitPoints($base, $removed);
    expect($this->character->currentHitPoints())->toBe($expected);
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

    expect($ja)->toBeArray();
    expect($ja)->toBe([
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

test('json array returns expected result with campaign', function () {
    $this->character->setHitPoints(25, 0);
    $this->character->setCampaign(1234567, 'The Dark Tower');
    $ja = $this->character->jsonArray();

    expect($ja)->toBeArray();
    expect($ja)->toBe([
        'id' => 1234567,
        'name' => 'Sir Didymus',
        'raceclass' => 'Knight of Yore Fighter/Bard',
        'level' => 3,
        'campaign_id' => 1234567,
        'campaign' => 'The Dark Tower',
        'hp' => '25/25',
        'avatar' => 'default.png',
    ]);
});
