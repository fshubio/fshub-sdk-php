<?php

namespace FsHub\Sdk\Entities;

use FsHub\Sdk\Types\Common;

class Ils
{
    /**
     * The ILS identification (name)
     * @var string|null
     */
    public ?string $ident = Common::DEFAULT_NULL_VALUE;

    /**
     * The ILS localiser frequency.
     * @var string|null
     */
    public ?string $frequency = Common::DEFAULT_NULL_VALUE;

    /**
     * The ILS heading.
     * @var int|null
     */
    public ?int $heading = Common::DEFAULT_NULL_VALUE;

    /**
     * The ILS glide slope angle.
     * @var int|null
     */
    public ?int $slope = Common::DEFAULT_NULL_VALUE;
}