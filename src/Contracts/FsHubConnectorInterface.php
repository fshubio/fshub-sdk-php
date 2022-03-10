<?php

namespace FsHub\Sdk\Contracts;

use FsHub\Sdk\Connectors\ConnectorResponse;

interface FsHubConnectorInterface
{
    public function Get(string $resourceIdentifier): ConnectorResponse;
}