<?php

use Pfaocle\DndBeyondCharacters\Campaign;

beforeeach(function () {
    $this->campaign = new Campaign(1234567, 'Test campaign');
});

test('create a campaign object', function () {
    $this->assertTrue($this->campaign instanceof Campaign);
    $this->assertEquals($this->campaign->id(), 1234567);
    $this->assertEquals($this->campaign->name(), 'Test campaign');
});

test('campaign path and public url', function () {
    $this->assertEquals($this->campaign->path(), '/campaigns/1234567');
    $this->assertEquals($this->campaign->publicUrl(), 'https://www.dndbeyond.com/campaigns/1234567');
    $this->assertEquals($this->campaign->publicUrl('https://example.com'), 'https://example.com/campaigns/1234567');
});
