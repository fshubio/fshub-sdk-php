<?php

namespace FsHub\Sdk\Types;

class Wind
{

    use CastableEntity;

    protected static $castMap = [
        'spd' => 'speed',
        'dir' => 'direction'
    ];

    /**
     * Wind Speed (kts)
     * @var int
     */
    public int $speed = Common::DEFAULT_INTEGER_VALUE;

    /**
     * Wind Direction (cardinal degrees)
     * @var int
     */
    public int $direction = Common::DEFAULT_INTEGER_VALUE;

}