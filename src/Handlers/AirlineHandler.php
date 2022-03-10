<?php

namespace FsHub\Sdk\Handlers;

use FsHub\Sdk\Contracts\FsHubConnectorInterface;

class AirlineHandler
{
    private FsHubConnectorInterface $_connector;

    public function __construct(FsHubConnectorInterface $connector)
    {
        reset();
        $this->_connector = $connector;
    }
}