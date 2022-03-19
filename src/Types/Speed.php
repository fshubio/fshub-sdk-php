<?php

namespace FsHub\Sdk\Types;

class Speed
{

    use CastableEntity;

    /**
     * True Air Speed
     * @var int
     */
    public int $tas = Common::DEFAULT_INTEGER_VALUE;

}