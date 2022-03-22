<?php

namespace FsHub\Sdk\Contracts;

use FsHub\Sdk\Connectors\ConnectorResponse;

interface FsHubConnectorInterface
{
    /**
     * Retrieve the data from the connector endpoint.
     * @param string $resourceIdentifier The resource identifier
     * @return ConnectorResponse
     */
    public function get(string $resourceIdentifier): ConnectorResponse;
}
