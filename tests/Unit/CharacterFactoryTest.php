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

    expect($character instanceof Character)->toBeTrue();
    expect($character->id())->toBe(1234567);
    expect($character->name())->toBe('Sir Didymus');
    expect($character->race())->toBe('Knight of Yore');
    expect($character->class())->toBe('Cleric');
    expect($character->level())->toBe(3);
    expect($character->campaignName())->toBe('No campaign');
    expect($character->avatar())->toBe('https://example.com/test.png');
});

test('valid creation with empty avatar', function () {
    $data = $this->data;
    $data->decorations->avatarUrl = '';
    $character = CharacterFactory::createFromJson($data);
    expect($character->avatar())->toBe('default.png');
});

test('valid creation with multiple classes', function () {
    $data = $this->data;
    $data->classes = [
        (object) ['level' => 3, 'definition' => (object) ['name' => 'Monk']],
        (object) ['level' => 1, 'definition' => (object) ['name' => 'Bard']],
    ];
    $character = CharacterFactory::createFromJson($data);
    expect($character->class())->toBe('Monk/Bard');
    expect($character->level())->toBe(4);
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

    expect($character->campaignName())->toBe('Quests of Yore');
    expect($character->campaignId())->toBe(1234567);

    expect(get_class($character->campaign()))->toBe('Pfaocle\DndBeyondCharacters\Campaign');
    expect($character->campaign()->id())->toBe(1234567);
    expect($character->campaign()->name())->toBe('Quests of Yore');
});
