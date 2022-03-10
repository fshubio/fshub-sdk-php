<?php

namespace FsHub\Sdk\Types;

class Wind
{

    use CastableEntity;

    protected static $castMap = [
        'spd' => 'speed',
        'dir' => 'direction'
    ];

    public int $speed = Common::DEFAULT_INTEGER_VALUE;

    public int $direction = Common::DEFAULT_INTEGER_VALUE;

}