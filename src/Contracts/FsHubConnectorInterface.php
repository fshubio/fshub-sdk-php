<?php

namespace FsHub\Sdk\Contracts;

use FsHub\Sdk\Connectors\ConnectorResponse;

interface FsHubConnectorInterface
{
    public function get(string $resourceIdentifier): ConnectorResponse;
}