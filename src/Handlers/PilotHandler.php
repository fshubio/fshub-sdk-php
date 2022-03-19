<?php

namespace FsHub\Sdk\Handlers;

use FsHub\Sdk\Contracts\FsHubConnectorInterface;
use FsHub\Sdk\Entities\Airlines;
use FsHub\Sdk\Entities\Flights;
use FsHub\Sdk\Entities\Pilot;
use FsHub\Sdk\Entities\Pilots;
use FsHub\Sdk\Entities\PilotStats;

class PilotHandler extends BaseFeatureHandler
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
     * Sets the pilot context.
     * @param int $id The pilot ID
     * @return PilotHandler
     */
    public function select(int $id): PilotHandler
    {
        $this->selectedId = $id;
        return $this;
    }

    /**
     * Set the offset (API cursor).
     * @param int $id The offset (API cursor) to retrieve collection items from.
     * @return PilotHandler
     */
    public function offset(int $id): PilotHandler
    {
        $this->cursor = $id;
        return $this;
    }

    /**
     * Set the number of collection items to return per request (API limit)
     * @param int $limit The number of collection items to return per request.
     * @return PilotHandler
     */
    public function take(int $limit = 10): PilotHandler
    {
        $this->limit = $limit;
        return $this;
    }

    /**
     * Resets the API cursor and limit values.
     * @return PilotHandler
     */
    private function reset(): PilotHandler
    {
        $this->cursor = self::DEFAULT_CURSOR_POSITION;
        $this->limit = self::DEFAULT_LIMIT;
        return $this;
    }

    /**
     * Return a single pilot entity.
     * @param int $id The pilot ID to return.
     * @return Pilot
     */
    public function first(int $id): Pilot
    {
        return Pilot::fromJson(
            $this->_connector->get("pilot/{$id}")->body
        );
    }

    /**
     * An alias of "First" - Returns a single pilot entity by the pilot ID.
     * @param int $id The pilot ID to return.
     * @return Pilot
     */
    public function find(int $id): Pilot
    {
        return $this->first($id);
    }

    /**
     * Return a collection of pilots from the current pilot ID (use "Offset" method to set the cursor)
     * @param int $id
     * @return Pilots
     */
    public function get(): Pilots
    {
        return Pilots::fromJson(
            $this->_connector->get("pilot?cursor={$this->cursor}&limit={$this->limit}")->body
        );
    }

    /**
     * Return flights flown by this pilot.
     * @return Flights
     * @throws \FsHub\Sdk\Exceptions\ContextNotSetException
     */
    public function flights(): Flights
    {
        $this->requiresSetContext($this->selectedId);
        return Flights::fromJson(
            $this->_connector->get("pilot/{$this->selectedId}/flight?cursor={$this->cursor}&limit={$this->limit}")->body
        );
    }

    /**
     * Return all airlines that this pilot belongs to.
     * @return Airlines
     * @throws \FsHub\Sdk\Exceptions\ContextNotSetException
     */
    public function airlines(): Airlines
    {
        $this->requiresSetContext($this->selectedId);
        return Airlines::fromJson(
            $this->_connector->get("pilot/{$this->selectedId}/airline?cursor={$this->cursor}&limit={$this->limit}")->body
        );
    }

    /**
     * Returns pilot stats for the currently selected pilot.
     * @return PilotStats
     * @throws \FsHub\Sdk\Exceptions\ContextNotSetException
     */
    public function stats(): PilotStats
    {
        $this->requiresSetContext($this->selectedId);
        return PilotStats::fromJson(
            $this->_connector->get("pilot/{$this->selectedId}/stats")->body
        );
    }

    /**
     * Return pilot flights that arrived at a specific airport.
     * @param string $icao The arrival airport ICAO code.
     * @return Flights
     * @throws \FsHub\Sdk\Exceptions\ContextNotSetException
     */
    public function arrivals(string $icao): Flights
    {
        $this->requiresSetContext($this->selectedId);
        return Flights::fromJson(
            $this->_connector->get("pilot/{$this->selectedId}/flight/arrival/{$icao}?cursor={$this->cursor}&limit={$this->limit}")->body
        );
    }

    /**
     * Return pilot flights that departed from a specific airport.
     * @param string $icao The departure airport ICAO code.
     * @return Flights
     * @throws \FsHub\Sdk\Exceptions\ContextNotSetException
     */
    public function departures(string $icao): Flights
    {
        $this->requiresSetContext($this->selectedId);
        return Flights::fromJson(
            $this->_connector->get("pilot/{$this->selectedId}/flight/departure/{$icao}?cursor={$this->cursor}&limit={$this->limit}")->body
        );
    }

    /**
     * Return pilot flights that flew a specific route (from a specific departure ICAO to a specific Arrival ICAO)
     * @param string $departure The departure airport ICAO code.
     * @param string $arrival The arrival airport ICAO code.
     * @return Flights
     * @throws \FsHub\Sdk\Exceptions\ContextNotSetException
     */
    public function route(string $departure, string $arrival): Flights
    {
        $this->requiresSetContext($this->selectedId);
        return Flights::fromJson(
            $this->_connector->get("pilot/{$this->selectedId}/flight/departure/{$departure}/arrival/{$arrival}?cursor={$this->cursor}&limit={$this->limit}")->body
        );
    }
}