<?php

namespace FsHub\Sdk\Entities;

use FsHub\Sdk\Types\Direction;
use FsHub\Sdk\Types\LatLng;
use FsHub\Sdk\Types\Speed;
use FsHub\Sdk\Types\Wind;

class Transition
{
    /**
     * The airport ICAO Code.
     * @var string
     */
    public ?string $icao;

    /**
     * The airport IATA Code.
     * @var string|null
     */
    public ?string $iata;

    /**
     * The airport name.
     * @var string|null
     */
    public ?string $name;

    /**
     * The date and time at the point of the transition.
     * @var \DateTime
     */
    public \DateTime $time;

    /**
     * The location of the transition.
     * @var LatLng
     */
    public LatLng $geo;

    /**
     * The heading of the transition.
     * @var Direction
     */
    public Direction $hdg;

    /**
     * Aircraft speed at transition.
     * @var Speed
     */
    public Speed $spd;

    /**
     * The amount of fuel onboard at the point of transition.
     * @var int
     */
    public int $fuel;

    /**
     * The aircraft pitch angle at the point of transition.
     * @var int
     */
    public int $pitch;

    /**
     * The aircraft bank angle at the point of transition.
     * @var int
     */
    public int $bank;

    /**
     * Wind speed and direction at the point of transition.
     * @var Wind
     */
    public Wind $wind;
}