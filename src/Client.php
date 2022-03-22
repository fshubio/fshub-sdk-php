<?php

namespace FsHub\Sdk;

use FsHub\Sdk\Connectors\HttpConnector;
use FsHub\Sdk\Contracts\FsHubConnectorInterface;
use FsHub\Sdk\Handlers\AirlineHandler;
use FsHub\Sdk\Handlers\AirportHandler;
use FsHub\Sdk\Handlers\FlightHandler;
use FsHub\Sdk\Handlers\PilotContextHandler;
use FsHub\Sdk\Handlers\PilotHandler;

class Client
{
    /**
     * An FsHub.io API key.
     * @var string
     */
    private readonly string $apiKey;

    /**
     * An FsHub data connector instance (implementation).
     * @var FsHubConnectorInterface
     */
    private readonly FsHubConnectorInterface $connector;

    /**
     * Current user (token) context
     * @var PilotContextHandler
     */
    public readonly PilotContextHandler $user;

    /**
     * Pilot(s)
     * @var PilotHandler
     */
    public readonly PilotHandler $pilots;

    /**
     * Airport(s)
     * @var AirportHandler
     */
    public readonly AirportHandler $airports;

    /**
     * Airline(s)
     * @var AirlineHandler
     */
    public readonly AirlineHandler $airlines;

    /**
     * Flight(s)
     * @var FlightHandler
     */
    public readonly FlightHandler $flights;

    /**
     * Create new instance of the FsHub SDK (REST API client).
     * @param string $apiKey An FsHub.io API key
     * @param FsHubConnectorInterface|null $connector An FsHubConnectorInterface implementation
     */
    public function __construct(string $apiKey, FsHubConnectorInterface $connector = null)
    {
        $this->apiKey = $apiKey;
        $this->connector = $connector ?? new HttpConnector($apiKey);

        $this->configureFeatures();
    }

    /**
     * Configure API feature accessors.
     * @return void
     */
    protected function configureFeatures(): void
    {
        $this->user = new PilotContextHandler($this->connector);
        $this->pilots = new PilotHandler($this->connector);
        $this->flights = new FlightHandler($this->connector);
        $this->airlines = new AirlineHandler($this->connector);
        $this->airports = new AirportHandler($this->connector);
    }
}
