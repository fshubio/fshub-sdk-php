<?php

namespace FsHub\Sdk\Entities;

use FsHub\Sdk\Types\CastableEntity;
use FsHub\Sdk\Types\Common;
use FsHub\Sdk\Types\SocialHandles;

class Airline
{

    use CastableEntity;

    public static array $castMap = [
        'id' => 'id',
        'name' => 'name',
        'abbr' => 'abbreviation',
    ];

    public int $id = Common::DEFAULT_INTEGER_VALUE;
    public string $name = Common::DEFAULT_STRING_VALUE;
    public string $abbreviation = Common::DEFAULT_STRING_VALUE;
    public ?PilotData $owner;
    public ?SocialHandles $handes;

}