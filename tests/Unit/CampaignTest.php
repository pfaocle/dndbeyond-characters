<?php

use Pfaocle\DndBeyondCharacters\Campaign;

beforeeach(function () {
    $this->campaign = new Campaign(1234567, 'Test campaign');
});

test('create a campaign object', function () {
    expect($this->campaign instanceof Campaign)->toBeTrue();
    expect($this->campaign->id())->toBe(1234567);
    expect($this->campaign->name())->toBe('Test campaign');
});

test('campaign path and public url', function () {
    expect($this->campaign->path())->toBe('/campaigns/1234567');
    expect($this->campaign->publicUrl())->toBe('https://www.dndbeyond.com/campaigns/1234567');
    expect($this->campaign->publicUrl('https://example.com'))->toBe('https://example.com/campaigns/1234567');
});
