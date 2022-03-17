<?php

namespace FsHub\Sdk\Handlers;

use FsHub\Sdk\Contracts\FsHubConnectorInterface;
use FsHub\Sdk\Entities\PilotContext;

class PilotContextHandler extends BaseFeatureHandler
{

    protected FsHubConnectorInterface $_connector;

    public function __construct(FsHubConnectorInterface $connector)
    {
        $this->_connector = $connector;
    }

    /**
     * Return the current pilot context - The API token owner pilot object.
     * @return PilotContext
     */
    public function Context(): PilotContext
    {
        return (new PilotContext())->fromJson($this->_connector->get("user")->body);
    }
}