<?php

namespace FsHub\Sdk\Entites;

use FsHub\Sdk\Types\CastableEntity;

class UserConf
{

    const DEFAULT_STRING_VALUE = "";

    use CastableEntity;

    public string $tailNumber = self::DEFAULT_STRING_VALUE;
    public string $icao = self::DEFAULT_STRING_VALUE;

}