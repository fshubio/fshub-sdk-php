<?php

namespace FsHub\Sdk\Types;

class Cursor
{

    use CastableEntity;

    public int $current = Common::DEFAULT_INTEGER_VALUE;
    public int $previous = Common::DEFAULT_INTEGER_VALUE;
    public int $next = Common::DEFAULT_INTEGER_VALUE;
    public int $count = Common::DEFAULT_INTEGER_VALUE;


}