<?php

namespace lucidtaz\analytics;

interface StorageInterface
{
    public function storeIdentify(string $userId, array $traits, array $context);
    public function storeTrack(string $userId, string $event, array $properties, array $context);
    public function storePage(string $userId, string $name, array $properties, array $context);
    public function storeAssociate(string $userId1, string $userId2, string $link, array $context);
}
