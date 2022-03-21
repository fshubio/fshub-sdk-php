<?php

namespace FsHub\Sdk\Entities;

use FsHub\Sdk\Contracts\AirlineInterface;

class Airline implements AirlineInterface
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

    public function getAirlineId(): int
    {
        return $this->data->id;
    }
}