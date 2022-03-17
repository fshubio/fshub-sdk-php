<?php

namespace FsHub\Sdk\Entities;

use DateTime;
use FsHub\Sdk\Types\CastableEntity;
use FsHub\Sdk\Types\Common;
use FsHub\Sdk\Types\LatLng;

class PilotContextData
{

    use CastableEntity;

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
     * @var string
     */
    public string $location;

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

    /**
     * @throws \Exception
     */
    public function fromArray(array $data)
    {

        $this->id = $data['id'];
        $this->name = $data['name'];
        $this->base = $data['base'];
        $this->location = $data['locale'];
        $this->isOnline = (bool)$data['is_online'];
        $this->onlineAt = new DateTime($data['online_at']);

        $this->gps = new LatLng();
        $this->gps->latitude = $data['gps']['lat'];
        $this->gps->longitude = $data['gps']['lng'];
    }
}