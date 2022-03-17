<?php

namespace FsHub\Sdk\Handlers;

use FsHub\Sdk\Contracts\FsHubConnectorInterface;
use FsHub\Sdk\Entities\Airline;
use FsHub\Sdk\Entities\Airlines;
use FsHub\Sdk\Entities\AirlineStats;
use FsHub\Sdk\Entities\Airport;
use FsHub\Sdk\Entities\Flights;
use FsHub\Sdk\Entities\Metar;
use FsHub\Sdk\Entities\Pilots;
use FsHub\Sdk\Entities\Screenshots;
use FsHub\Sdk\Exceptions\AirportNotFoundException;
use FsHub\Sdk\Exceptions\NoMetarFoundException;

class AirportHandler extends BaseFeatureHandler
{
    protected FsHubConnectorInterface $_connector;

    private const DEFAULT_LIMIT = 10;

    private const DEFAULT_CURSOR_POSITION = 0;

    private string $selectedIcao = "";

    public function __construct(FsHubConnectorInterface $connector)
    {
        $this->reset();
        $this->_connector = $connector;
    }

    /**
     * Sets the airport context.
     * @param string $icao The airport ICAO
     * @return AirportHandler
     */
    public function select(string $icao): AirportHandler
    {
        $this->selectedIcao = $icao;
        return $this;
    }

    /**
     * Set the offset (API cursor).
     * @param int $id The offset (API cursor) to retrieve collection items from.
     * @return AirportHandler
     */
    public function offset(int $id): AirportHandler
    {
        $this->cursor = $id;
        return $this;
    }

    /**
     * Set the number of collection items to return per request (API limit)
     * @param int $limit The number of collection items to return per request.
     * @return AirportHandler
     */
    public function take(int $limit = 10): AirportHandler
    {
        $this->limit = $limit;
        return $this;
    }

    /**
     * Resets the API cursor and limit values.
     * @return AirportHandler
     */
    private function reset(): AirportHandler
    {
        $this->cursor = self::DEFAULT_CURSOR_POSITION;
        $this->limit = self::DEFAULT_LIMIT;
        return $this;
    }

    /**
     * Return a single airport entity.
     * @param string $icao The airport ICAO.
     * @return Airport
     */
    public function first(string $icao): Airport
    {
        return Airport::fromJson(
            $this->_connector->Get("airport/{$icao}")->body
        );
    }

    /**
     * An alias of "First" - Returns a single airport entity by the airline ID.
     * @param string $icao The airport ICAO to return.
     * @return Airport
     */
    public function find(string $icao): Airport
    {
        return $this->first($icao);
    }

    /**
     * Return the METAR report for this airport.
     * @return Metar
     * @throws AirportNotFoundException
     * @throws NoMetarFoundException
     * @throws \FsHub\Sdk\Exceptions\ContextNotSetException
     */
    public function metar(): Metar
    {
        $this->requiresSetContext($this->selectedIcao);

        $metar = Metar::fromJson(
            $this->_connector->Get("airport/{$this->selectedIcao}/metar")->body
        );

        // If we could not find the airport we'll throw an Airport Not Found exception instead...
        if ($metar->error) {
            throw new AirportNotFoundException("The airport ICAO ({$this->selectedIcao}) is not valid or could not be found!");
        }

        // If no METAR information is found BUT the airport is valid, we'll throw a No METAR found exception...
        if ($metar->data->metar->error) {
            throw new NoMetarFoundException("No METAR information found for this airport ({$this->selectedIcao}).");
        }

        return $metar;
    }

    /**
     * Return flights that arrived at this airport.
     * @return Flights
     * @throws \FsHub\Sdk\Exceptions\ContextNotSetException
     */
    public function arrivals(): Flights
    {
        $this->requiresSetContext($this->selectedIcao);
        return Flights::fromJson(
            $this->_connector->Get("airport/{$this->selectedIcao}/arrival?cursor={$this->cursor}&limit={$this->limit}")->body
        );
    }

    /**
     * Return flights that departed from this airport.
     * @return Flights
     * @throws \FsHub\Sdk\Exceptions\ContextNotSetException
     */
    public function departures(): Flights
    {
        $this->requiresSetContext($this->selectedIcao);
        return Flights::fromJson(
            $this->_connector->Get("airport/{$this->selectedIcao}/departure?cursor={$this->cursor}&limit={$this->limit}")->body
        );
    }

    /**
     * Return flights that departed from this airport and landed at the specified airport.
     * @param string $icao
     * @return Flights
     * @throws \FsHub\Sdk\Exceptions\ContextNotSetException
     */
    public function departuresTo(string $icao): Flights
    {
        $this->requiresSetContext($this->selectedIcao);
        return Flights::fromJson(
            $this->_connector->Get("airport/{$this->selectedIcao}/departure/{$icao}?cursor={$this->cursor}&limit={$this->limit}")->body
        );
    }

    /**
     * Return flights that arrived at this airport from the specified airport.
     * @param string $icao
     * @return Flights
     * @throws \FsHub\Sdk\Exceptions\ContextNotSetException
     */
    public function arrivalsFrom(string $icao): Flights
    {
        $this->requiresSetContext($this->selectedIcao);
        return Flights::fromJson(
            $this->_connector->Get("airport/{$this->selectedIcao}/arrival/{$icao}?cursor={$this->cursor}&limit={$this->limit}")->body
        );
    }

}