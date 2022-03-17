<?php

namespace FsHub\Sdk\Handlers;

use FsHub\Sdk\Contracts\FsHubConnectorInterface;
use FsHub\Sdk\Entities\Flight;
use FsHub\Sdk\Entities\Flights;
use FsHub\Sdk\Entities\Screenshots;

class FlightHandler extends BaseFeatureHandler
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
     * Sets the flight context.
     * @param int $id The airline ID
     * @return FlightHandler
     */
    public function select(int $id): FlightHandler
    {
        $this->selectedId = $id;
        return $this;
    }

    /**
     * Set the offset (API cursor).
     * @param int $id The offset (API cursor) to retrieve collection items from.
     * @return FlightHandler
     */
    public function offset(int $id): FlightHandler
    {
        $this->cursor = $id;
        return $this;
    }

    /**
     * Set the number of collection items to return per request (API limit)
     * @param int $limit The number of collection items to return per request.
     * @return FlightHandler
     */
    public function take(int $limit = 10): FlightHandler
    {
        $this->limit = $limit;
        return $this;
    }

    /**
     * Resets the API cursor and limit values.
     * @return FlightHandler
     */
    private function reset(): FlightHandler
    {
        $this->cursor = self::DEFAULT_CURSOR_POSITION;
        $this->limit = self::DEFAULT_LIMIT;
        return $this;
    }

    /**
     * Return a single flight entity.
     * @param int $id The flight ID to return.
     * @return Flight
     */
    public function first(int $id): Flight
    {
        return Flight::fromJson(
            $this->_connector->Get("flight/{$id}")->body
        );
    }

    /**
     * An alias of "First" - Returns a single flight entity by the flight ID.
     * @param int $id The flight ID to return.
     * @return Flight
     */
    public function find(int $id): Flight
    {
        return $this->first($id);
    }

    /**
     * Return a collection of flights from the current flight ID (use "Offset" method to set the cursor)
     * @return Flights
     */
    public function get(): Flights
    {
        return Flights::fromJson(
            $this->_connector->Get("flight?cursor={$this->cursor}&limit={$this->limit}")->body
        );
    }

    /**
     * Return a collection of screenshots that have been uploaded against this flight report.
     * @return Screenshots
     */
    public function screenshots(): Screenshots
    {
        return Screenshots::fromJson(
            $this->_connector->Get("flight/{$this->selectedId}/screenshot?cursor={$this->cursor}&limit={$this->limit}")->body
        );
    }


}