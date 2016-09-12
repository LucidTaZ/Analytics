<?php

namespace lucidtaz\analytics;

interface ContextInterface
{
    /**
     * Get context values
     * This entails all useful information about the currect execution
     * environment, such as: headers, IP address, system versions, library
     * version, ...
     * @returns array Associative, with string keys and string values
     */
    public function get(): array;
}
