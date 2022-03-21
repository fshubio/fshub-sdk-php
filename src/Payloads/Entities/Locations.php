<?php

namespace FsHub\Sdk\Payloads\Entities;

class Locations
{
    /**
     * The pilot's home airport (base)
     * @var string
     */
    public string $base;

    /**
     * The pilot's last known location (where they last landed)
     * @var string|null
     */
    public ?string $locale;

    public function fromArray(array $data)
    {
        $this->base = isset($data['base']) ? $data['base'] : null;
        $this->locale = isset($data['locale']) ? $data['locale'] : null;
    }
}