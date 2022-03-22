<?php

namespace FsHub\Sdk\Entities;

use FsHub\Sdk\Contracts\PilotInterface;

class Pilot implements PilotInterface
{
    /**
     * Pilot Data
     * @var PilotData
     */
    public PilotData $data;

    public static function fromJson(string $json): Pilot
    {
        $pilot = new Pilot();
        $data = json_decode($json, true);

        $casted = new PilotData();
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
