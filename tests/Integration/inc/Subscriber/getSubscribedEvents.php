<?php

namespace LaunchpadRenderer\Tests\Integration\inc\Subscriber;

use LaunchpadRenderer\Tests\Integration\TestCase;

/**
 * @covers \LaunchpadRenderer\Subscriber::get_subscribed_events
 */
class Test_getSubscribedEvents extends TestCase {

    /**
     * @dataProvider configTestData
     */
    public function testShouldReturnAsExpected( $config, $expected )
    {

    }
}
