<?php

namespace FsHub\Sdk\Entities;

use FsHub\Sdk\Types\CastableEntity;
use FsHub\Sdk\Types\Common;

class Frequencies
{
    use CastableEntity;

    private static $castMap = [
        'atis' => 'atis',
        'cd' => 'clearanceDelivery',
        'gnd' => 'ground',
        'tower' => 'tower',
        'unicom' => 'unicom',
        'multicom' => 'multicom',
        'app' => 'approach',
        'dep' => 'departure',
    ];

    /**
     * ATIS frequency
     * @var string|null
     */
    public ?string $atis = Common::DEFAULT_NULL_VALUE;

    /**
     * Clearance Delivery frequency
     * @var string|null
     */
    public ?string $clearanceDelivery = Common::DEFAULT_NULL_VALUE;

    /**
     * Ground frequency
     * @var string|null
     */
    public ?string $ground = Common::DEFAULT_NULL_VALUE;

    /**
     * Tower frequency
     * @var string|null
     */
    public ?string $tower = Common::DEFAULT_NULL_VALUE;

    /**
     * UNICOM frequency
     * @var string|null
     */
    public ?string $unicom = Common::DEFAULT_NULL_VALUE;

    /**
     * MULTICOM frequency
     * @var string|null
     */
    public ?string $multicom = Common::DEFAULT_NULL_VALUE;

    /**
     * Approach frequency
     * @var string|null
     */
    public ?string $approach = Common::DEFAULT_NULL_VALUE;

    /**
     * Departure frequency
     * @var string|null
     */
    public ?string $departure = Common::DEFAULT_NULL_VALUE;
}
