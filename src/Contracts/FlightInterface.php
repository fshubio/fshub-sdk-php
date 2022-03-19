<?php

namespace FsHub\Sdk\Contracts;

interface FlightInterface
{

    /**
     * The Flight ID.
     * @return int
     */
    public function getFlightId(): int;
}