<?php

namespace FsHub\Sdk\Payloads\Entities;

class FlightPlan
{
    /**
     * The flight number or call sign as optionally set by the user
     * @var int
     */
    public readonly ?string $callSign;

    /**
     * The planned cruise level in
     * @var int
     */
    public readonly int $cruiseLevel;

    /**
     * The planned departure airport (ICAO code)
     * @var string
     */
    public readonly string $departure;

    /**
     * The planned arrival airport (ICAO code)
     * @var string
     */
    public readonly string $arrival;

    public function fromArray(array $data): FlightPlan
    {
        $this->callSign = $data['flight_no'] ?? null;
        $this->cruiseLevel = $data['cruise_lvl'];
        $this->departure = $data['departure'];
        $this->arrival = $data['arrival'];
        return $this;
    }
}
