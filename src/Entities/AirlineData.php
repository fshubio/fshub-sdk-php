<?php

namespace FsHub\Sdk\Entities;

use FsHub\Sdk\Contracts\AirlineInterface;
use FsHub\Sdk\Types\SocialHandles;

class AirlineData implements AirlineInterface
{
    /**
     * The airline ID.
     * @var int
     */
    public int $id;

    /**
     * The airline name.
     * @var string
     */
    public string $name;

    /**
     * The airline abbreviation.
     * @var string
     */
    public string $abbreviation;

    /**
     * The airline owner entity.
     * @var PilotData
     */
    public PilotData $owner;

    /**
     * The airline social media handles.
     * @var SocialHandles
     */
    public SocialHandles $handles;

    public function fromArray(array $data)
    {
        $this->id = $data['id'];
        $this->name = $data['name'];
        $this->abbreviation = $data['abbr'];

        if (isset($data['owner'])) {
            $this->owner = new PilotData();
            $this->owner->fromArray($data['owner']);
        }

        if (isset($data['handles'])) {
            $this->handles = new SocialHandles();
            $this->handles->website = $data['handles']['website'];
            $this->handles->facebook = $data['handles']['facebook'];
            $this->handles->twitter = $data['handles']['twitter'];
            $this->handles->vatsim = null; // Airlines don't have the option to set VATSIM ID so we set this to null by default!
            $this->handles->ivao = null; // Airlines don't have the option to set IVAO so we set this to null by default!
        }
    }

    /***
     * @inheritdoc
     */
    public function getAirlineId(): int
    {
        return $this->id;
    }
}
