<?php

namespace FsHub\Sdk\Types;

class Direction
{

    use CastableEntity;

    protected static $castMap = [
        'mag' => 'magnetic',
        'true' => 'true'
    ];

    public int $magnetic = Common::DEFAULT_INTEGER_VALUE;
    public int $true = Common::DEFAULT_INTEGER_VALUE;

}