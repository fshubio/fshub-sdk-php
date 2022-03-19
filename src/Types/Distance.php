<?php

namespace FsHub\Sdk\Types;

class Distance
{

    use CastableEntity;

    protected static $castMap = [
        'nm' => 'nauticalMiles',
        'km' => 'kilometres'
    ];

    /**
     * As nautical miles (NM)
     * @var float
     */
    public float $nauticalMiles = Common::DEFAULT_DOUBLE_VALUE;

    /**
     * As kilometres (km)
     * @var float
     */
    public float $kilometres = Common::DEFAULT_DOUBLE_VALUE;


}