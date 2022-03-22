<?php

namespace FsHub\Sdk\Payloads\Entities;

use FsHub\Sdk\Types\LatLng;

class Locale
{
    /**
     * The City name.
     * @var string|null
     */
    public ?string $city;

    /**
     * The State or Province name.
     * @var string|null
     */
    public ?string $state;

    /**
     * The Country name.
     * @var string
     */
    public string $country;

    /**
     * GPS representation of the location.
     * @var LatLng
     */
    public LatLng $gps;

    public function fromArray(array $data): Locale
    {
        $this->city = isset($data['city']) ? $data['city'] : null;
        $this->state = isset($data['state']) ? $data['state'] : null;
        $this->country = $data['country'];

        $gps = new LatLng();
        $gps->latitude = $data['gps']['lat'];
        $gps->longitude = $data['gps']['lng'];
        $this->gps = $gps;

        return $this;
    }
}
