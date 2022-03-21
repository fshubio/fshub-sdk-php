<?php

namespace FsHub\Sdk\Entities;

class AirlineStats
{

    /**
     * Airline statistics data
     * @var AirlineStatsData
     */
    public AirlineStatsData $data;

    public static function fromJson(string $json): AirlineStats
    {
        $airline = new AirlineStats();
        $data = json_decode($json, true);

        $casted = new AirlineStatsData();
        $casted->fromArray($data['data']);
        $airline->data = $casted;

        return $airline;
    }

}