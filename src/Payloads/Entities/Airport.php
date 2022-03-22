<?php

namespace FsHub\Sdk\Payloads\Entities;

use FsHub\Sdk\Contracts\AirportInterface;
use FsHub\Sdk\Types\Common;
use FsHub\Sdk\Types\SocialHandles;

class Airport implements AirportInterface
{

    /**
     * The airport ICAO code
     * @var string
     */
    public readonly string $icao;

    /**
     * The airport IATA code
     * @var string|null
     */
    public readonly ?string $iata;

    /**
     * The airport name
     * @var string
     */
    public readonly string $name;

    /**
     * The airport locale information
     * @var Locale
     */
    public readonly Locale $locale;

    public function fromArray(array $data): Airport
    {
        $this->icao = $data['icao'];
        $this->iata = $data['iata'];
        $this->name = $data['name'];

        $this->locale = (new Locale())->fromArray($data['locale']);

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getAirportIcao(): string
    {
        return $this->icao;
    }
}