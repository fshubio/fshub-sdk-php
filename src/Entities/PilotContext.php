<?php

namespace FsHub\Sdk\Entities;

use FsHub\Sdk\Contracts\PilotInterface;
use FsHub\Sdk\Exceptions\EntityNotSetException;
use FsHub\Sdk\Types\CastableEntity;

class PilotContext implements PilotInterface
{

    use CastableEntity;

    public PilotContextData $data;

    public static function fromJson(string $json): PilotContext
    {
        $pilot = new PilotContext();
        $data = json_decode($json, true);

        $casted = new PilotContextData();
        $casted->fromArray($data['data']);
        $pilot->data = $casted;

        return $pilot;
    }

    public function getPilotId(): int
    {
        if ($this->data != null) {
            return $this->data->id;
        }
        throw new EntityNotSetException("No pilot context has been set, retrieve a pilot object first and try again!");
    }
}