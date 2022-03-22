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
    private readonly string $_apiKey;

    /**
     * An FsHub data connector instance (implementation).
     * @var FsHubConnectorInterface
     */
    private readonly FsHubConnectorInterface $_connector;

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
    public function __construct(string $apiKey, ?FsHubConnectorInterface $connector = null)
    {
        $this->_apiKey = $apiKey;
        $this->_connector = $connect ?? new HttpConnector($apiKey);

        $this->configureFeatures();
    }

    /**
     * Configure API feature accessors.
     * @return void
     */
    protected function configureFeatures(): void
    {
        $this->user = new PilotContextHandler($this->_connector);
        $this->pilots = new PilotHandler($this->_connector);
        $this->flights = new FlightHandler($this->_connector);
        $this->airlines = new AirlineHandler($this->_connector);
        $this->airports = new AirportHandler($this->_connector);
    }

}