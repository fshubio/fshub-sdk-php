<?php

namespace FsHub\Sdk\Handlers;

use FsHub\Sdk\Contracts\FsHubConnectorInterface;
use FsHub\Sdk\Entities\PilotContext;

class PilotContextHandler extends BaseFeatureHandler
{
    protected FsHubConnectorInterface $connector;

    public function __construct(FsHubConnectorInterface $connector)
    {
        $this->connector = $connector;
    }

    /**
     * Return the current pilot context - The API token owner pilot object.
     * @return PilotContext
     */
    public function context(): PilotContext
    {
        return (new PilotContext())->fromJson($this->connector->get("user")->body);
    }
}
