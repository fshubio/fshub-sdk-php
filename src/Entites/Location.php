<?php

namespace FsHub\Sdk\Entites;

use FsHub\Sdk\Types\CastableEntity;
use FsHub\Sdk\Types\Common;

class Location
{

    use CastableEntity;

    public string $city = Common::DEFAULT_STRING_VALUE;
    public string $state = Common::DEFAULT_STRING_VALUE;
    public string $country = Common::DEFAULT_STRING_VALUE;
}