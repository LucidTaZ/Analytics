<?php

namespace lucidtaz\analytics\tests;

use lucidtaz\analytics\Analytics;
use lucidtaz\analytics\ContextInterface;
use lucidtaz\analytics\StorageInterface;
use PHPUnit\Framework\TestCase;

class AnalyticsTest extends TestCase
{
    public function testIdentify()
    {
        $userId = 'user 123';
        $traits = [
            'test' => 'yes',
            'live' => 'no',
        ];
        $mockedContextValues = [
            'context1' => 'something',
            'context2' => 'something else',
        ];

        $context = $this->getMockedContextReturning($mockedContextValues);

        $storage = $this->getMockBuilder(StorageInterface::class)
            ->setMethods(['storeIdentify'])
            ->getMockForAbstractClass();
        $storage->expects($this->once())
            ->method('storeIdentify')
            ->with($userId, $traits, $mockedContextValues);

        $analytics = $this->makeObject($context, $storage);

        $analytics->identify($userId, $traits);
    }

    public function testTrack()
    {
        $userId = 'user 123';
        $event = 'test_executed';
        $properties = [
            'test' => 'yes',
            'live' => 'no',
        ];
        $mockedContextValues = [
            'context1' => 'something',
            'context2' => 'something else',
        ];

        $context = $this->getMockedContextReturning($mockedContextValues);

        $storage = $this->getMockBuilder(StorageInterface::class)
            ->setMethods(['storeTrack'])
            ->getMockForAbstractClass();
        $storage->expects($this->once())
            ->method('storeTrack')
            ->with($userId, $event, $properties, $mockedContextValues);

        $analytics = $this->makeObject($context, $storage);

        $analytics->track($userId, $event, $properties);
    }

    public function testPage()
    {
        $userId = 'user 123';
        $name = 'test_suite';
        $properties = [
            'test' => 'yes',
            'live' => 'no',
        ];
        $mockedContextValues = [
            'context1' => 'something',
            'context2' => 'something else',
        ];

        $context = $this->getMockedContextReturning($mockedContextValues);

        $storage = $this->getMockBuilder(StorageInterface::class)
            ->setMethods(['storePage'])
            ->getMockForAbstractClass();
        $storage->expects($this->once())
            ->method('storePage')
            ->with($userId, $name, $properties, $mockedContextValues);

        $analytics = $this->makeObject($context, $storage);

        $analytics->page($userId, $name, $properties);
    }

    public function testAssociate()
    {
        $userId1 = 'user 123';
        $userId2 = 'user 124';
        $link = 'friends';
        $mockedContextValues = [
            'context1' => 'something',
            'context2' => 'something else',
        ];

        $context = $this->getMockedContextReturning($mockedContextValues);

        $storage = $this->getMockBuilder(StorageInterface::class)
            ->setMethods(['storeAssociate'])
            ->getMockForAbstractClass();
        $storage->expects($this->once())
            ->method('storeAssociate')
            ->with($userId1, $userId2, $link, $mockedContextValues);

        $analytics = $this->makeObject($context, $storage);

        $analytics->associate($userId1, $userId2, $link);
    }

    private function getMockedContextReturning(array $values)
    {
        $context = $this->getMockBuilder(ContextInterface::class)
            ->setMethods(['get'])
            ->getMockForAbstractClass();
        $context->expects($this->any())
            ->method('get')
            ->willReturn($values);
        return $context;
    }

    private function makeObject(ContextInterface $context, StorageInterface $storage)
    {
        $analytics = new Analytics();
        $analytics->setContext($context);
        $analytics->setStorage($storage);
        return $analytics;
    }
}
