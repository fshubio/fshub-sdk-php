<?php

namespace FsHub\Sdk\Entities;

use FsHub\Sdk\Types\CastableEntity;
use FsHub\Sdk\Types\Common;

class Location
{

    use CastableEntity;

    public static array $castMap = [
        'city' => 'city',
        'state' => 'state',
        'county' => 'country', // Typo in the actual FsHub API (will map this correctly here!)
    ];

    public string $city = Common::DEFAULT_STRING_VALUE;
    public string $state = Common::DEFAULT_STRING_VALUE;
    public string $country = Common::DEFAULT_STRING_VALUE;
}