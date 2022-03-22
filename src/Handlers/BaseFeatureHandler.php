<?php

namespace FsHub\Sdk\Handlers;

use FsHub\Sdk\Contracts\FsHubConnectorInterface;
use FsHub\Sdk\Exceptions\ContextNotSetException;

class BaseFeatureHandler
{
    protected FsHubConnectorInterface $connector;

    private const ERROR_MESSAGE = "No context has been set, use the Select(x) fluent method to set/select a context!";

    /**
     *The configured record (API collection) limit.
     */
    protected int $limit = 10;

    /**
     * The configured API navigation "cursor" that is used to return data collections.
     * @var int
     */
    protected int $cursor = 0;

    /**
     * Validation checks for methods required a set context.
     * @param $value
     * @return void
     * @throws ContextNotSetException
     */
    protected function requiresSetContext($value): void
    {
        if ($value == null || $value == "" || $value == 0) {
            throw new ContextNotSetException(self::ERROR_MESSAGE);
        }
    }
}
