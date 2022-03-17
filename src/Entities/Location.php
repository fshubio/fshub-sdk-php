<?php

namespace FsHub\Sdk\Entities;

use FsHub\Sdk\Types\CastableEntity;
use FsHub\Sdk\Types\Common;

class Location
{
    public string $city = Common::DEFAULT_STRING_VALUE;
    public string $state = Common::DEFAULT_STRING_VALUE;
    public string $country = Common::DEFAULT_STRING_VALUE;
}