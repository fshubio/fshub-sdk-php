<?php

namespace FsHub\Sdk\Entities;

use FsHub\Sdk\Contracts\PilotInterface;

class PilotStatsData implements PilotInterface
{
    /**
     * The pilot ID.
     * @var int
     */
    public int $id;

    /**
     * All-time pilot statistics.
     * @var StatsData
     */
    public StatsData $allTime;

    /**
     * Pilot stats for the last 30 days.
     * @var StatsData
     */
    public StatsData $currentMonth;

    public function fromArray(array $data)
    {
        $this->id = $data['id'];

        $allTime = new StatsData();
        $allTime->flights = $data['all_time']['total_flights'];
        $allTime->hours = $data['all_time']['total_hours'];
        $allTime->distance = $data['all_time']['total_distance'];
        $allTime->averageLandingRate = $data['all_time']['average_landing'];
        $this->allTime = $allTime;

        $currentMonth = new StatsData();
        $currentMonth->flights = $data['month']['total_flights'];
        $currentMonth->hours = $data['month']['total_hours'];
        $currentMonth->distance = $data['month']['total_distance'];
        $currentMonth->averageLandingRate = $data['month']['average_landing'];
        $this->currentMonth = $currentMonth;
    }

    /**
     * @inheritdoc
     */
    public function getPilotId(): int
    {
        return $this->id;
    }
}
