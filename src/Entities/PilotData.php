<?php

namespace FsHub\Sdk\Entities;

use DateTime;
use FsHub\Sdk\Types\LatLng;
use FsHub\Sdk\Types\SocialHandles;

class PilotData
{

    /**
     * The Pilot ID
     * @var int
     */
    public int $id;

    /**
     * The Pilot's name
     * @var string
     */
    public string $name;

    /**
     * The pilot's bio/description
     * @var string
     */
    public ?string $bio;

    /**
     * The pilot's social media handles.
     * @var SocialHandles
     */
    public ?SocialHandles $handles;

    /**
     * The pilot's home airport (base)
     * @var string
     */
    public ?string $base;

    /**
     * The location as to where the pilot is current (airport ICAO code)
     * @var string
     */
    public ?string $location;

    /**
     * The current or last known location for the pilots/aircraft.
     * @var LatLng
     */
    public ?LatLng $gps;

    /**
     * The pilot's timezone.
     * @var string
     */
    public ?string $timezone;

    /**
     * The country (ISO) code for this pilot.
     * @var string
     */
    public ?string $country;

    /**
     * Indicates the user is either online or offline.
     * @var bool
     */
    public ?bool $isOnline;

    /**
     * Indicates when the user was last online
     * @var DateTime
     */
    public ?DateTime $onlineAt;

    /**
     * Indicates when the user account was created.
     * @var DateTime
     */
    public ?DateTime $createdAt;

    /**
     * Convert array data PilotData object properties.
     * @param array $data
     * @return void
     * @throws \Exception
     */
    public function fromArray(array $data)
    {

        $this->id = $data['id'];
        $this->name = $data['name'];
        $this->bio = $data['bio'] ?? null;
        $this->base = $data['base'] ?? null;
        $this->location = $data['locale'] ?? null;
        $this->country = $data['country'] ?? null;
        $this->timezone = $data['timezone'] ?? null;

        $this->isOnline = (bool)($data['is_online'] ?? false);

        if (isset($data['gps'])) {
            $this->gps = new LatLng();
            $this->gps->latitude = $data['gps']['lat'];
            $this->gps->longitude = $data['gps']['lng'];
        }

        if (isset($data['handles'])) {
            $this->handles = new SocialHandles();
            $this->handles->website = $data['handles']['website'];
            $this->handles->facebook = $data['handles']['facebook'];
            $this->handles->twitter = $data['handles']['twitter'];
            $this->handles->vatsim = $data['handles']['vatsim'];
            $this->handles->ivao = $data['handles']['ivao'];
        }

        if (isset($data['online_at'])) {
            $this->onlineAt = new DateTime($data['online_at']);
        }
        if (isset($data['created_at'])) {
            $this->createdAt = new DateTime($data['created_at']);
        }
    }

}