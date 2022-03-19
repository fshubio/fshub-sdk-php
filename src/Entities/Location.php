<?php

namespace FsHub\Sdk\Entities;

use FsHub\Sdk\Types\CastableEntity;
use FsHub\Sdk\Types\Common;

class Location
{

    /**
     * City name
     * @var string
     */
    public string $city = Common::DEFAULT_STRING_VALUE;

    /**
     * State name
     * @var string
     */
    public string $state = Common::DEFAULT_STRING_VALUE;

    /**
     * Country name
     * @var string
     */
    public string $country = Common::DEFAULT_STRING_VALUE;
}