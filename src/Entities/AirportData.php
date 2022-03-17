<?php

namespace FsHub\Sdk\Entities;

use FsHub\Sdk\Contracts\AirportInterface;
use FsHub\Sdk\Types\Common;
use FsHub\Sdk\Types\LatLng;

class AirportData
{

    /**
     * The Airport ICAO code.
     * @var string
     */
    public string $icao;

    /**
     * The Airport IATA code (if applicable).
     * @var string|null
     */
    public ?string $iata;

    /**
     * The Airport name.
     * @var string
     */
    public string $name;

    /**
     * The Airport location details.
     * @var Location
     */
    public Location $locale;

    /**
     * Airport GPS data.
     * @var LatLng
     */
    public LatLng $geo;

    /**
     * Airport field elevation (in feet above sea-level)
     * @var int|null
     */
    public ?int $elevation;

    /**
     * Magnetic variation observed at the airport.
     * @var int|null
     */
    public ?int $magneticVariation;

    /**
     * Airport radio frequencies.
     * @var Frequencies
     */
    public Frequencies $frequencies;

    /**
     * Airport runway information.
     * @var array<Runway>
     */
    public array $runways;

    public function fromArray(array $data): void
    {
        $this->name = $data['name'];
        $this->icao = $data['icao'];
        $this->iata = $data['iata'] ?? null;
        $this->elevation = $data['alt'] ?? null;
        $this->magneticVariation = $data['mag_var'] ?? null;

        $this->locale = new Location();
        $this->locale->city = $data['locale']['city'] ?? '';
        $this->locale->state = $data['locale']['state'] ?? '';
        $this->locale->country = $data['locale']['county'] ?? '';
        
        $this->frequencies = Frequencies::cast($data['frequencies']);
        $this->geo = LatLng::cast($data['geo']);


        foreach ($data['runways'] as $runway) {
            $this->runways[] = Runway::fromArray($runway);
        }


    }
}