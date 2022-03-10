<?php

namespace FsHub\Sdk\Handlers;

use FsHub\Sdk\Contracts\FsHubConnectorInterface;
use FsHub\Sdk\Exceptions\ContextNotSetException;

class BaseFeatureHandler
{
    protected FsHubConnectorInterface $_connector;

    /**
     *The configured record (API collection) limit.
     */
    protected int $limit = 10;

    /**
     * The configured API navigation "cursor" that is used to return data collections.
     * @var int
     */
    protected int $cursor = 0;

    private const ERROR_MESSAGE = "No context has been set, use the Select(x) fluent method to set/select a context!";

    protected function requiresSetContext($value): void
    {
        if ($value == null || $value == "") {
            throw new ContextNotSetException(self::ERROR_MESSAGE);
        }
    }
    
}
