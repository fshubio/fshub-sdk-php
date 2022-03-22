<?php

namespace FsHub\Sdk\Types;

class Direction
{
    use CastableEntity;

    protected static $castMap = [
        'mag' => 'magnetic',
        'true' => 'true'
    ];

    /**
     * Magnetic heading (direction) in cardinal degrees.
     * @var int
     */
    public int $magnetic = Common::DEFAULT_INTEGER_VALUE;

    /**
     * True heading (direction) in cardinal degrees.
     * @var int
     */
    public int $true = Common::DEFAULT_INTEGER_VALUE;
}
