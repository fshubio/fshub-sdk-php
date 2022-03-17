<?php

namespace FsHub\Sdk\Entities;

use FsHub\Sdk\Contracts\AirportInterface;

class Airport implements AirportInterface
{
    public AirportData $data;

    public static function fromJson(string $json): Airport
    {
        $airport = new Airport();
        $data = json_decode($json, true);

        $casted = new AirportData();
        $casted->fromArray($data['data']);
        $airport->data = $casted;

        return $airport;
    }

    public function getAirportIcao(): string
    {
        return $this->data->icao;
    }

}