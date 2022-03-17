<?php

namespace FsHub\Sdk\Entites;

use FsHub\Sdk\Contracts\PilotInterface;

class Pilot implements PilotInterface
{

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

    public function getPilotId(): int
    {
        return $this->data->id;
    }
}