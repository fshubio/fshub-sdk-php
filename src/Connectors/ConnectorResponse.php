<?php

namespace FsHub\Sdk\Connectors;

use FsHub\Sdk\Exceptions\InvalidApiKeyException;
use FsHub\Sdk\Exceptions\NoRecordsFoundException;
use FsHub\Sdk\Exceptions\RateLimitExceededException;

class ConnectorResponse
{
    public int $status;
    public array $meta = [];
    public ?string $body;

    public function validate(): bool
    {
        switch ($this->status) {
            case 429:
                throw new RateLimitExceededException(
                    "You have been rate limited due to the number of API requests you have performed, please wait before trying again.");
            case 401:
                throw new InvalidApiKeyException(
                    "The API key specified is not valid, please check and try again.");
            case 404:
                throw new NoRecordsFoundException("No API resource(s) have been found.");
            default:
                return true;
        }
    }

}