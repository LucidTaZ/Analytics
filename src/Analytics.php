<?php

namespace lucidtaz\analytics;

/**
 * Server-side analytics tool
 */
class Analytics
{
    /**
     * @var ContextInterface
     */
    private $context;

    /**
     * @var StorageInterface
     */
    private $storage;

    public function __construct()
    {

    }

    public function __destruct()
    {

    }

    /**
     * Identify a user along with its traits
     * This registers the user in the analytics system.
     * @param string $userId
     * @param array $traits Associative array with string keys and string values.
     */
    public function identify(string $userId, array $traits = [])
    {
        $this->storage->storeIdentify($userId, $traits, $this->context->get());
    }

    /**
     * Track an event within the system
     * @param string $userId The user that triggered the event
     * @param string $event The name of the event
     * @param array $properties Associative array with string keys and string values.
     */
    public function track(string $userId, string $event, array $properties = [])
    {
        $this->storage->storeTrack($userId, $event, $properties, $this->context->get());
    }

    /**
     * Register a page view
     * @param string $userId The user that views the page
     * @param string $name The name of the page
     * @param array $properties Associative array with string keys and string values.
     */
    public function page(string $userId, string $name, array $properties = [])
    {
        $this->storage->storePage($userId, $name, $properties, $this->context->get());
    }

    /**
     * Associate two users with each other
     * This can be used for example to map friendships or transitions from one
     * account to another.
     * @param string $userId1
     * @param string $userId2
     * @param string $link Name of the relations between the users
     */
    public function associate(string $userId1, string $userId2, string $link)
    {
        $this->storage->storeAssociate($userId1, $userId2, $link, $this->context->get());
    }

    public function setContext(ContextInterface $context)
    {
        $this->context = $context;
    }

    public function setStorage(StorageInterface $storage)
    {
        $this->storage = $storage;
    }
}
