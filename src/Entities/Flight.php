<?php

namespace FsHub\Sdk\Entities;

class Flight
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

}