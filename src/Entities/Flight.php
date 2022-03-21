<?php

namespace FsHub\Sdk\Entities;

use FsHub\Sdk\Contracts\FlightInterface;

class Flight implements FlightInterface
{

    /**
     * Airline Data
     * @var FlightData
     */
    public FlightData $data;

    public static function fromJson(string $json): Flight
    {

        $flight = new Flight();
        $data = json_decode($json, true);

        $casted = new FlightData();
        $casted->fromArray($data['data']);
        $flight->data = $casted;

        return $flight;
    }

    /**
     * @inheritdoc
     */
    public function getFlightId(): int
    {
        return $this->data->id;
    }
}