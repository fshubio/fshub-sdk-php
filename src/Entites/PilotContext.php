<?php

namespace FsHub\Sdk\Entites;

use FsHub\Sdk\Contracts\PilotInterface;
use FsHub\Sdk\Exceptions\EntityNotSetException;
use FsHub\Sdk\Types\CastableEntity;

class PilotContext implements PilotInterface
{

    use CastableEntity;

    public ?PilotContextData $data;

    public static function fromJson(string $json): PilotContext
    {
        // @todo Convert the JSON to the data structure as required (this is normally automatically taken care of in .NET but I'll need
        // to do this manually...
    }

    public function getPilotId(): int
    {
        if ($this->data != null) {
            return $this->data->id;
        }
        throw new EntityNotSetException("No pilot context has been set, retrieve a pilot object first and try again!");
    }
}