<?php

namespace FsHub\Sdk\Contracts;

interface PilotInterface
{
    /**
     * The Pilot ID.
     * @return int
     */
    public function getPilotId(): int;
}