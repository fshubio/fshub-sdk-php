<?php

namespace FsHub\Sdk\Entites;

use FsHub\Sdk\Types\CastableEntity;

class Aircraft
{
    use CastableEntity;

    public function __construct(
        public string $icao,
        public string $icaoName,
        public string $name,
        public string $type,
        public UserConf $userConf
    ) {
    }


}