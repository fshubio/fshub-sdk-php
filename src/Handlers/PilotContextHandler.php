<?php

namespace FsHub\Sdk\Handlers;

use FsHub\Sdk\Contracts\FsHubConnectorInterface;
use FsHub\Sdk\Entites\PilotContext;

class PilotContextHandler extends BaseFeatureHandler
{

    protected FsHubConnectorInterface $_connector;

    public function __construct(FsHubConnectorInterface $connector)
    {
        $this->_connector = $connector;
    }

    public function Context(): PilotContext
    {
        return PilotContext::fromJson($this->_connector->get("user"));
    }
}