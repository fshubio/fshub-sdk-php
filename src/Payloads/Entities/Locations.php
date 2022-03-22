<?php

namespace FsHub\Sdk\Payloads\Entities;

class Locations
{
    /**
     * The pilot's home airport (base)
     * @var string|null
     */
    public readonly string $base;

    /**
     * The pilot's last known location (where they last landed)
     * @var string|null
     */
    public readonly ?string $locale;

    public function fromArray(array $data): Locations
    {
        $this->base = $data['base'] ?? null;
        $this->locale = $data['locale'] ?? null;

        return $this;
    }
}
