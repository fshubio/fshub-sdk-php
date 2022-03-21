<?php

namespace FsHub\Sdk\Payloads\Entities;

class Profile
{

    /**
     * Avatar URL (if applicable).
     * @var string|null
     */
    public ?string $avatarUrl;

    /**
     * Bio text (if applicable)
     * @var string|null
     */
    public ?string $bio;


    /**
     * Airline specific abbreviation (if applicable).
     * @var string|null
     */
    public ?string $abbreviation;

    public function fromArray(array $data)
    {
        $this->avatarUrl = isset($data['avatar_url']) ? $data['avatar_url'] : null;
        $this->bio = isset($data['bio']) ? $data['bio'] : null;
        $this->abbreviation = isset($data['abbreviation']) ? $data['abbreviation'] : null;
    }

}