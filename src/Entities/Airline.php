<?php

namespace FsHub\Sdk\Entities;

class Airline
{

    /**
     * Airline Data
     * @var AirlineData
     */
    public AirlineData $data;

    public static function fromJson(string $json): Airline
    {

        $airline = new Airline();
        $data = json_decode($json, true);

        $casted = new AirlineData();
        $casted->fromArray($data['data']);
        $airline->data = $casted;

        return $airline;
    }

}