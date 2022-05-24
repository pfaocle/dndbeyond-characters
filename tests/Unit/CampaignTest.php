<?php

use Pfaocle\DndBeyondCharacters\Campaign;

test('create a campaign object', function () {
    $campaign = new Campaign(1234567, 'Test campaign');
    $this->assertTrue($campaign instanceof Campaign);
    $this->assertEquals($campaign->id(), 1234567);
    $this->assertEquals($campaign->name(), 'Test campaign');
    $this->assertEquals($campaign->path(), '/campaigns/1234567');
});
