<?php

namespace FsHub\Sdk\Contracts;

use FsHub\Sdk\Types\LatLng;

interface GeolocatableInterface
{
    /**
     * The LatLng representation for this location.
     * @return LatLng
     */
    public function location(): LatLng;
}
