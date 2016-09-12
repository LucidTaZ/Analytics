<?php

namespace lucidtaz\analytics\tests;

use LogicException;
use lucidtaz\analytics\Analytics;
use lucidtaz\analytics\DeferredAnalytics;
use PHPUnit\Framework\TestCase;

class DeferredAnalyticsTest extends TestCase
{
    public function testIdentify()
    {
        $analyticsComponent = new AnalyticsSpy;
        $deferredAnalytics = new DeferredAnalytics($analyticsComponent);

        $userId = 'user 123';
        $traits = [];
        $deferredAnalytics->identify($userId, $traits);

        $this->assertFalse($analyticsComponent->identifyCalled);

        unset($deferredAnalytics);
        gc_collect_cycles();

        $this->assertTrue($analyticsComponent->identifyCalled);
    }

    public function testClone()
    {
        // Clone is forbidden since it would duplicate the deferred calls
        $deferredAnalytics = new DeferredAnalytics(new Analytics);

        $this->expectException(LogicException::class);
        clone $deferredAnalytics;
    }
}
