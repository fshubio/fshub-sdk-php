<?php

namespace FsHub\Sdk\Types;

class Cursor
{
    use CastableEntity;

    /**
     * The current cursor position.
     * @var int
     */
    public int $current = Common::DEFAULT_INTEGER_VALUE;

    /**
     * The previous cursor position.
     * @var int
     */
    public int $previous = Common::DEFAULT_INTEGER_VALUE;

    /**
     * The next cursor position.
     * @var int
     */
    public int $next = Common::DEFAULT_INTEGER_VALUE;

    /**
     * The total number of collection items returned for this request.
     * @var int
     */
    public int $count = Common::DEFAULT_INTEGER_VALUE;
}
