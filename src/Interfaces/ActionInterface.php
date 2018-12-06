<?php

namespace Syzn\MicropayClient\Interfaces;

interface ActionInterface
{

    /**
     * Retrieve action's endpoint uri
     *
     * @return string
     */
    public static function getEndpointUri(): string;

    /**
     * Retrieve action's request method
     *
     * @return array
     */
    public function getMethod(): string;

    /**
     * Retrieve action's values
     *
     * @return array
     */
    public function getValues(): array;
}
