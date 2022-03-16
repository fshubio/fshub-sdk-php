<?php

namespace FsHub\Sdk\Entites;

class Flight
{

    public FlightData $data;

    public static function fromJson(string $json): Flight
    {

        $flight = new Flight();
        $data = json_decode($json, true);
        $flight->data = (new FlightData())->fromArray($data['data']);
        return $flight->data;
    }

}