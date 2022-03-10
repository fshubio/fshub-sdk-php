<?php

namespace FsHub\Sdk\Entites;

use FsHub\Sdk\Types\CastableEntity;
use FsHub\Sdk\Types\Common;

class Aircraft
{
    use CastableEntity;

    public string $icao = Common::DEFAULT_STRING_VALUE;
    public string $icaoName = Common::DEFAULT_STRING_VALUE;
    public string $name = Common::DEFAULT_STRING_VALUE;
    public string $type = Common::DEFAULT_STRING_VALUE;
    public ?UserConf $userConf;


}