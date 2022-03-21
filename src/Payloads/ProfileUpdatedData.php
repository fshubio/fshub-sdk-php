<?php

namespace FsHub\Sdk\Payloads;

use FsHub\Sdk\Payloads\Entities\Locations;
use FsHub\Sdk\Payloads\Entities\Profile;
use FsHub\Sdk\Types\SocialHandles;

class ProfileUpdatedData
{

    /**
     * The Pilot ID.
     * @var int
     */
    public readonly int $id;

    /**
     * The Pilot's name.
     * @var string
     */
    public readonly string $name;

    /**
     * The Pilot's email address.
     * @var string
     */
    public readonly string $email;

    /**
     * Profile customisables
     * @var Profile
     */
    public readonly Profile $profile;

    /**
     * Pilot locales.
     * @var Locations
     */
    public readonly Locations $locations;

    /**
     * Pilot social media handles.
     * @var SocialHandles
     */
    public readonly SocialHandles $handles;

    /**
     * The pilot's timezone.
     * @var string
     */
    public readonly string $timezone;

    /**
     * The pilot's country ISO code.
     * @var string
     */
    public readonly string $country;


    public function fromArray(array $data)
    {
        $this->id = $data['id'];

        $this->name = $data['name'];
        $this->email = $data['email'];
        $this->timezone = $data['timezone'];
        $this->country = $data['country'];

        $profile = new Profile();
        $profile->fromArray($data['profile']);
        $this->profile = $profile;

        $locations = new Locations();
        $locations->fromArray($data['locations']);
        $this->locations = $locations;

        $handles = new SocialHandles();
        $handles->website = $data['handles']['website'];
        $handles->facebook = $data['handles']['facebook'];
        $handles->twitter = $data['handles']['twitter'];
        $handles->vatsim = $data['handles']['vatsim'];
        $handles->ivao = $data['handles']['ivao'];
        $this->handles = $handles;

    }
}