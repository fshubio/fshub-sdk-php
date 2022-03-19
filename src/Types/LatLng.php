<?php

namespace FsHub\Sdk\Types;

use FsHub\Sdk\Contracts\GeolocatableInterface;

class LatLng implements GeolocatableInterface
{

    use CastableEntity;

    protected static $castMap = [
        'lat' => 'latitude',
        'lng' => 'longitude'
    ];

    /**
     * Latitude
     * @var float
     */
    public float $latitude = 0.0;

    /**
     * Longitude
     * @var float
     */
    public float $longitude = 0.0;

    /**
     * Convert to a standardised text representation of a lat/lng.
     * @return string
     */
    public function __toString(): string
    {
        return "{$this->latitude},{$this->longitude}";
    }

    /**
     * Convert to a JSON object.
     * @return string
     */
    public function toJson(): string
    {
        return json_encode(['lat' => $this->latitude, 'lng' => $this->longitude]);
    }

    /**
     * GeolocatableInterface compatibility.
     * @return $this
     */
    public function location(): LatLng
    {
        return $this;
    }
}