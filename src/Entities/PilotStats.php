<?php

namespace FsHub\Sdk\Entities;

use FsHub\Sdk\Contracts\PilotInterface;

class PilotStats implements PilotInterface
{
    /**
     * Pilot statistics data
     * @var PilotStatsData
     */
    public PilotStatsData $data;

    public static function fromJson(string $json): PilotStats
    {
        $pilot = new PilotStats();
        $data = json_decode($json, true);

        $casted = new PilotStatsData();
        $casted->fromArray($data['data']);
        $pilot->data = $casted;

        return $pilot;
    }

    /**
     * @inheritdoc
     */
    public function getPilotId(): int
    {
        return $this->data->id;
    }
}
