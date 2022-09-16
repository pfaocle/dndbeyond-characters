<?php

use Pfaocle\DndBeyondCharacters\Character;
use Pfaocle\DndBeyondCharacters\CharacterFactory;

beforeeach(function () {
    $this->data = (object) [
        'id' => 1234567,
        'name' => 'Sir Didymus',
        'race' => (object) ['fullName' => 'Knight of Yore'],
        'classes' => [
            (object) ['level' => 3, 'definition' => (object) ['name' => 'Cleric']],
        ],
        'stats' => [2 => (object) ['value' => 11]],
        'baseHitPoints' => 25,
        'removedHitPoints' => 0,
        'campaign' => (object) ['name' => 'No campaign'],
        'decorations' => (object) ['avatarUrl' => 'https://example.com/test.png'],
    ];
});

test('valid character creation', function () {
    $character = CharacterFactory::createFromJson($this->data);

    $this->assertTrue($character instanceof Character);
    $this->assertEquals($character->id(), 1234567);
    $this->assertEquals($character->name(), 'Sir Didymus');
    $this->assertEquals($character->race(), 'Knight of Yore');
    $this->assertEquals($character->class(), 'Cleric');
    $this->assertEquals($character->level(), 3);
    $this->assertEquals($character->campaign(), 'No campaign');
    $this->assertEquals($character->avatar(), 'https://example.com/test.png');
});

test('valid creation with empty avatar', function () {
    $data = $this->data;
    $data->decorations->avatarUrl = '';
    $character = CharacterFactory::createFromJson($data);
    $this->assertEquals($character->avatar(), 'default.png');
});

test('valid creation with multiple classes', function () {
    $data = $this->data;
    $data->classes = [
        (object) ['level' => 3, 'definition' => (object) ['name' => 'Monk']],
        (object) ['level' => 1, 'definition' => (object) ['name' => 'Bard']],
    ];
    $character = CharacterFactory::createFromJson($data);
    $this->assertEquals($character->class(), 'Monk/Bard');
    $this->assertEquals($character->level(), 4);
});

test('non-numeric id cannot be used', function () {
    $data = $this->data;
    $data->id = 'abcdef';
    CharacterFactory::createFromJson($data);
})->throws('TypeError');

test('id must be present', function () {
    $data = $this->data;
    unset($data->id);
    CharacterFactory::createFromJson($data);
})->throws(Exception::class, 'No character ID found in JSON.');

test('campaign', function () {
    $data = $this->data;
    $data->campaign = (object) ['id' => 1234567, 'name' => 'Quests of Yore'];
    $character = CharacterFactory::createFromJson($data);

    $this->assertEquals($character->campaign(), 'Quests of Yore');
    $this->assertEquals($character->campaignId(), 1234567);

    $this->assertEquals(get_class($character->campaignObject()), 'Pfaocle\DndBeyondCharacters\Campaign');
    $this->assertEquals($character->campaignObject()->id(), 1234567);
    $this->assertEquals($character->campaignObject()->name(), 'Quests of Yore');
});
