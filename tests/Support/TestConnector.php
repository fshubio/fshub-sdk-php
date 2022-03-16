<?php

namespace FsHub\Sdk\Tests\Support;

use FsHub\Sdk\Connectors\ConnectorResponse;
use FsHub\Sdk\Contracts\FsHubConnectorInterface;

class TestConnector implements FsHubConnectorInterface
{
    public function Get(string $resourceIdentifier): ConnectorResponse
    {
        return new ConnectorResponse();
    }
}