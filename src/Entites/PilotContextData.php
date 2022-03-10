<?php

namespace FsHub\Sdk\Entites;

use DateTime;
use FsHub\Sdk\Types\CastableEntity;
use FsHub\Sdk\Types\Common;
use FsHub\Sdk\Types\LatLng;

class PilotContextData
{

    use CastableEntity;

    protected static $castMap = [
        'id' => 'id',
        'name' => 'name',
        'base' => 'base',
        'locale' => 'location',
        'gps' => 'gps',
        'is_online' => 'isOnline',
        'online_at' => 'onlineAt'
    ];

    /**
     * The Pilot ID (User ID)
     * @var int
     */
    public int $id = Common::DEFAULT_INTEGER_VALUE;

    /**
     * The Pilot's name
     * @var string|null
     */
    public ?string $name;

    /**
     * The Pilot's home airport (base)
     * @var string|null
     */
    public ?string $base;

    /**
     * The location as to where the pilot is current (airport ICAO code)
     * @var Location|null
     */
    public ?Location $location;

    /**
     * The current or last known location for the pilot/aircraft.
     * @var LatLng|null
     */
    public ?LatLng $gps;

    /**
     * Indicates the user is either online or offline.
     * @var bool
     */
    public bool $isOnline = false;

    /**
     * The last time the user was "online"/active.
     * @var DateTime
     */
    public ?DateTime $onlineAt;
}