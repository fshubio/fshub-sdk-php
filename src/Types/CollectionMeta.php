<?php

namespace FsHub\Sdk\Types;

class CollectionMeta
{

    /**
     * The API Metadata Cursor.
     * @var Cursor
     */
    public Cursor $cursor;

    public function __construct()
    {
        $this->cursor = new Cursor();
    }

}