<?php

namespace FsHub\Sdk\Handlers;

use FsHub\Sdk\Contracts\FsHubConnectorInterface;
use FsHub\Sdk\Entities\Airline;
use FsHub\Sdk\Entities\Airlines;
use FsHub\Sdk\Entities\AirlineStats;
use FsHub\Sdk\Entities\Flights;
use FsHub\Sdk\Entities\Pilots;
use FsHub\Sdk\Entities\Screenshots;

class AirlineHandler extends BaseFeatureHandler
{
    protected FsHubConnectorInterface $_connector;

    private const DEFAULT_LIMIT = 10;

    private const DEFAULT_CURSOR_POSITION = 0;

    private int $selectedId = 0;

    public function __construct(FsHubConnectorInterface $connector)
    {
        $this->reset();
        $this->_connector = $connector;
    }

    /**
     * Sets the airline context.
     * @param int $id The airline ID
     * @return AirlineHandler
     */
    public function select(int $id): AirlineHandler
    {
        $this->selectedId = $id;
        return $this;
    }

    /**
     * Set the offset (API cursor).
     * @param int $id The offset (API cursor) to retrieve collection items from.
     * @return AirlineHandler
     */
    public function offset(int $id): AirlineHandler
    {
        $this->cursor = $id;
        return $this;
    }

    /**
     * Set the number of collection items to return per request (API limit)
     * @param int $limit The number of collection items to return per request.
     * @return AirlineHandler
     */
    public function take(int $limit = 10): AirlineHandler
    {
        $this->limit = $limit;
        return $this;
    }

    /**
     * Resets the API cursor and limit values.
     * @return AirlineHandler
     */
    private function reset(): AirlineHandler
    {
        $this->cursor = self::DEFAULT_CURSOR_POSITION;
        $this->limit = self::DEFAULT_LIMIT;
        return $this;
    }

    /**
     * Return a single airline entity.
     * @param int $id The airline ID to return.
     * @return Airline
     */
    public function first(int $id): Airline
    {
        return Airline::fromJson(
            $this->_connector->Get("airline/{$id}")->body
        );
    }

    /**
     * An alias of "First" - Returns a single airline entity by the airline ID.
     * @param int $id The airline ID to return.
     * @return Airline
     */
    public function find(int $id): Airline
    {
        return $this->first($id);
    }

    /**
     * Return a collection of airlines from the current airline ID (use "Offset" method to set the cursor)
     * @return Airlines
     */
    public function get(): Airlines
    {
        return Airlines::fromJson(
            $this->_connector->Get("airline?cursor={$this->cursor}&limit={$this->limit}")->body
        );
    }

    /**
     * Returns airline stats for the currently selected airline.
     * @return AirlineStats
     * @throws \FsHub\Sdk\Exceptions\ContextNotSetException
     */
    public function stats(): AirlineStats
    {
        $this->requiresSetContext($this->selectedId);
        return AirlineStats::fromJson(
            $this->_connector->Get("airline/{$this->selectedId}/stats")->body
        );
    }

    /**
     * Return pilots that are members of this virtual airline.
     * @return Pilots
     * @throws \FsHub\Sdk\Exceptions\ContextNotSetException
     */
    public function pilots(): Pilots
    {
        $this->requiresSetContext($this->selectedId);
        return Pilots::fromJson(
            $this->_connector->Get("airline/{$this->selectedId}/pilot?cursor={$this->cursor}&limit={$this->limit}")->body
        );
    }

    /**
     * Return airline flights that arrived at a specific airport.
     * @param string $icao The arrival airport ICAO code.
     * @return Flights
     * @throws \FsHub\Sdk\Exceptions\ContextNotSetException
     */
    public function arrivals(string $icao): Flights
    {
        $this->requiresSetContext($this->selectedId);
        return Flights::fromJson(
            $this->_connector->Get("airline/{$this->selectedId}/arrival/{$icao}?cursor={$this->cursor}&limit={$this->limit}")->body
        );
    }

    /**
     * Return airline flights that departed from a specific airport.
     * @param string $icao The departure airport ICAO code.
     * @return Flights
     * @throws \FsHub\Sdk\Exceptions\ContextNotSetException
     */
    public function departures(string $icao): Flights
    {
        $this->requiresSetContext($this->selectedId);
        return Flights::fromJson(
            $this->_connector->Get("airline/{$this->selectedId}/departure/{$icao}?cursor={$this->cursor}&limit={$this->limit}")->body
        );
    }

    /**
     * Return airline flights that flew a specific route (from a specific departure ICAO to a specific Arrival ICAO)
     * @param string $departure The departure airport ICAO code.
     * @param string $arrival The arrival airport ICAO code.
     * @return Flights
     * @throws \FsHub\Sdk\Exceptions\ContextNotSetException
     */
    public function route(string $departure, string $arrival): Flights
    {
        $this->requiresSetContext($this->selectedId);
        return Flights::fromJson(
            $this->_connector->Get("airline/{$this->selectedId}/departure/{$departure}/arrival/{$arrival}?cursor={$this->cursor}&limit={$this->limit}")->body
        );
    }

    /**
     * Returns the virtual airline uploaded screenshots that appear on the virtual airline's profile page.
     * @return Screenshots
     * @throws \FsHub\Sdk\Exceptions\ContextNotSetException
     */
    public function screenshots(): Screenshots
    {
        $this->requiresSetContext($this->selectedId);
        return Screenshots::fromJson(
            $this->_connector->Get("airline/{$this->selectedId}/screenshot?cursor={$this->cursor}&limit={$this->limit}")->body
        );
    }

}