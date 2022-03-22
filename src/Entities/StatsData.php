<?php

namespace FsHub\Sdk\Entities;

class StatsData
{
    /**
     * Total number of flights.
     * @var int
     */
    public int $flights;

    /**
     * Total number of flight hours (airborne)
     * @var float
     */
    public float $hours;

    /**
     * Total distance (nautical miles) flown.
     * @var int
     */
    public int $distance;

    /**
     * The average landing rate (feet per minute)
     * @var int
     */
    public int $averageLandingRate;
}
