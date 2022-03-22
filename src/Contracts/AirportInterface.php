<?php

namespace FsHub\Sdk\Contracts;

interface AirportInterface
{
    /**
     * The airport ICAO code.
     * @return string
     */
    public function getAirportIcao(): string;
}
