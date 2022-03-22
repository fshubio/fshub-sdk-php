<?php

namespace FsHub\Sdk\Payloads\Entities;

use FsHub\Sdk\Contracts\PilotInterface;
use FsHub\Sdk\Types\SocialHandles;

class User implements PilotInterface
{
    /**
     * The user/pilot ID
     * @var int
     */
    public readonly int $id;

    /**
     * The user/pilot name
     * @var string
     */
    public readonly string $name;

    /**
     * The user/pilot email address
     * @var string
     */
    public readonly string $email;

    /**
     * The user/pilot profile entity
     * @var Profile
     */
    public readonly Profile $profile;

    /**
     * The user/pilot locations entity
     * @var Locations
     */
    public readonly Locations $location;

    /**
     * The user/pilot social media handles
     * @var SocialHandles
     */
    public readonly SocialHandles $handles;

    /**
     * The user/pilot's timezone
     * @var string
     */
    public readonly string $timezone;

    /**
     * The user/pilot's country
     * @var string
     */
    public readonly string $country;


    public function fromArray(array $data): User
    {
        $this->id = $data['id'];
        $this->name = $data['name'];
        $this->email = $data['email'];
        $this->timezone = $data['timezone'];
        $this->country = $data['country'];

        $this->profile = (new Profile())->fromArray($data['profile']);
        $this->location = (new Locations())->fromArray($data['locations']);
        $this->handles = (new SocialHandles())->cast($data['handles']);
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getPilotId(): int
    {
        return $this->id;
    }
}
