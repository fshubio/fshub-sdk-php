<?php

namespace FsHub\Sdk\Types;

class Distance
{

    use CastableEntity;

    protected static $castMap = [
        'nm' => 'nauticalMiles',
        'km' => 'kilometres'
    ];

    public float $nauticalMiles = Common::DEFAULT_DOUBLE_VALUE;
    public float $kilometres = Common::DEFAULT_DOUBLE_VALUE;


}