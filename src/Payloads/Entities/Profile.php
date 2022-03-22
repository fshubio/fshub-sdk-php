<?php

namespace FsHub\Sdk\Payloads\Entities;

use FsHub\Sdk\Types\Common;

class Profile
{
    /**
     * Avatar URL (if applicable).
     * @var string|null
     */
    public readonly ?string $avatarUrl;

    /**
     * Bio text (if applicable)
     * @var string|null
     */
    public readonly ?string $bio;

    /**
     * Airline specific abbreviation (if applicable).
     * @var string|null
     */
    public readonly ?string $abbreviation;

    public function fromArray(array $data): Profile
    {
        $this->avatarUrl = $data['avatar_url'] ?? null;
        $this->bio = $data['bio'] ?? null;
        $this->abbreviation = $data['abbreviation'] ?? null;
        return $this;
    }
}
