<?php

namespace lucidtaz\analytics\tests;

use lucidtaz\analytics\Analytics;

class AnalyticsSpy extends Analytics
{
    public $identifyCalled = false;
    public $trackCalled = false;
    public $pageCalled = false;
    public $associateCalled = false;

    public function identify(string $userId, array $traits = [])
    {
        $this->identifyCalled = true;
    }

    public function track(string $userId, string $event, array $properties = [])
    {
        $this->trackCalled = true;
    }

    public function page(string $userId, string $name, array $properties = [])
    {
        $this->pageCalled = true;
    }

    public function associate(string $userId1, string $userId2, string $link)
    {
        $this->associateCalled = true;
    }
}
