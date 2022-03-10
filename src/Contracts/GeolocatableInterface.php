<?php

namespace FsHub\Sdk\Contracts;

use FsHub\Sdk\Types\LatLng;

interface GeolocatableInterface
{
    public function location(): LatLng;
}