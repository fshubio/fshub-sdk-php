<?php

namespace FsHub\Sdk\Payloads\Entities;

use FsHub\Sdk\Contracts\AirlineInterface;
use FsHub\Sdk\Types\SocialHandles;

class Airline implements AirlineInterface
{
    /**
     * The airline ID
     * @var int
     */
    public readonly int $id;

    /**
     * The airline owner
     * @var User
     */
    public readonly User $owner;

    /**
     * The airline name
     * @var string
     */
    public readonly string $name;

    /**
     * The airline profile details
     * @var Profile
     */
    public readonly Profile $profile;

    /**
     * The airline social media handles
     * @var SocialHandles
     */
    public readonly SocialHandles $handles;

    public function fromArray(array $data): Airline
    {
        $this->id = $data['id'];
        $this->name = $data['name'];
        $this->owner = (new User())->fromArray($data['owner']);
        $this->profile = (new Profile())->fromArray($data['profile']);
        $this->handles = (new SocialHandles())->cast($data['handles']);

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getAirlineId(): int
    {
        return $this->id;
    }
}