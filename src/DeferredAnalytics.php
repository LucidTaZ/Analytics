<?php

namespace lucidtaz\analytics;

use Closure;
use LogicException;

/**
 * Decorator to defer calls to a later moment
 * This means that the user doesn't have to wait for the execution of analytics
 * code, as it can be deferred to after the user disconnects.
 *
 * Note that while such functionality would typically be implemented in a
 * shutdown handler, this is not the case. Instead, we implement it in the
 * destructor of this class. Make sure the DeferredAnalytics object remains in
 * scope until your application is torn down, for example by destroying the
 * object after the user disconnects, or simply letting PHP handle it at the end
 * of the execution.
 */
class DeferredAnalytics extends Analytics
{
    /**
     * @var Analytics
     */
    private $component;

    /**
     * @var Closure[] "Shutdown funtions" that are executed when this object is
     * destroyed. This is an alternative to registering them in the shutdown
     * handler, an approach which cannot be tested well.
     */
    private $closures = [];

    public function __construct(Analytics $analytics)
    {
        parent::__construct();
        $this->component = $analytics;
    }

    public function __clone()
    {
        // (Alternatively we may allow cloning but explicitly not clone the collected closures)
        throw new LogicException('Please do not clone! It messes with the shutdown closures.');
    }

    public function __destruct()
    {
        foreach ($this->closures as $closure) {
            $closure();
        }
        parent::__destruct();
    }

    public function identify(string $userId, array $traits = [])
    {
        $this->closures[] = function () use ($userId, $traits) {
            $this->component->identify($userId, $traits);
        };
    }

    public function track(string $userId, string $event, array $properties = [])
    {
        $this->closures[] = function () use ($userId, $event, $properties) {
            $this->component->track($userId, $event, $properties);
        };
    }

    public function page(string $userId, string $name, array $properties = [])
    {
        $this->closures[] = function () use ($userId, $name, $properties) {
            $this->component->page($userId, $name, $properties);
        };
    }

    public function associate(string $userId1, string $userId2, string $link)
    {
        $this->closures[] = function () use ($userId1, $userId2, $link) {
            $this->component->associate($userId1, $userId2, $link);
        };
    }
}
