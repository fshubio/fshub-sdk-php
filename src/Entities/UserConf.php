<?php

namespace FsHub\Sdk\Entities;

use FsHub\Sdk\Types\CastableEntity;

class UserConf
{

    const DEFAULT_STRING_VALUE = "";

    use CastableEntity;

    public static array $castMap = [
        'tail' => 'tailNumber',
        'icao' => 'icao',
    ];

    /**
     * The aircraft tail number (as set by the user through the LRM Aircraft Manager feature.
     * @var string
     */
    public string $tailNumber = self::DEFAULT_STRING_VALUE;

    /**
     * The aircraft ICAO code (as set by the user through the LRM Aircraft Manager feature.
     * @var string
     */
    public string $icao = self::DEFAULT_STRING_VALUE;

}