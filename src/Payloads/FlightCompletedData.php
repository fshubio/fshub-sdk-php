<?php

namespace FsHub\Sdk\Payloads;

use FsHub\Sdk\Contracts\FlightInterface;
use FsHub\Sdk\Entities\FlightMaxValues;
use FsHub\Sdk\Payloads\Entities\Aircraft;
use FsHub\Sdk\Payloads\Entities\Airline;
use FsHub\Sdk\Payloads\Entities\Airport;
use FsHub\Sdk\Payloads\Entities\FlightPlan;
use FsHub\Sdk\Payloads\Entities\Heading;
use FsHub\Sdk\Payloads\Entities\User;
use FsHub\Sdk\Payloads\Entities\Weight;
use FsHub\Sdk\Payloads\Entities\Wind;
use FsHub\Sdk\Types\Distance;
use FsHub\Sdk\Types\LatLng;
use mysql_xdevapi\SqlStatementResult;

class FlightCompletedData implements FlightInterface
{

    /**
     * The flight ID
     * @var int
     */
    public readonly int $id;

    /**
     * The pilot entity
     * @var User
     */
    public readonly User $pilot;

    /**
     * The aircraft entity
     * @var Aircraft
     */
    public readonly Aircraft $aircraft;

    /**
     * The airline entity
     * @var Airline|null
     */
    public readonly ?Airline $airline;

    /**
     * The flight plan entity
     * @var FlightPlan|null
     */
    public readonly ?FlightPlan $plan;

    /**
     * The departure transition entity
     * @var FlightDepartedData|null
     */
    public readonly ?FlightDepartedData $departure;

    /**
     * The arrival transition entity.
     * @var FlightArrivedData
     */
    public readonly FlightArrivedData $arrival;

    /**
     * The total (track) distance flown
     * @var Distance
     */
    public readonly Distance $distance;

    /**
     * Maximum flight statistics values
     * @var FlightMaxValues
     */
    public readonly FlightMaxValues $max;

    /**
     * The amount of fuel (in KGS) used.
     * @var int
     */
    public readonly int $fuelUsed;

    /**
     * Flight map data points as a GeoJSON string.
     * @var int
     */
    public readonly string $geoJson;

    /**
     * Flight statistics chart (ALT and SPD) as a JSON string.
     * @var string
     */
    public readonly string $chartJson;

    /**
     * Optional flight remarks.
     * @var string|null
     */
    public readonly ?string $remarks;

    /**
     * Optional flight tags (as a comma seperated string).
     * @var string|null
     */
    public readonly ?string $tags;

    public function fromArray(array $data)
    {
        $this->id = $data['id'];

        $this->pilot = (new User())->fromArray($data['user']);
        $this->aircraft = (new Aircraft())->fromArray($data['aircraft']);
        $this->airline = $data['airline'] ? (new Airline())->fromArray($data['airline']) : null;
        $this->plan = $data['plan'] ? (new FlightPlan())->fromArray($data['plan']) : null;

        if (isset($data['departure'])) {
            $departure = new FlightDepartedData();
            $departure->fromArray($data['departure']);
            $this->departure = $departure;
        }

        $arrival = new FlightArrivedData();
        $arrival->fromArray($data['arrival']);
        $this->arrival = $arrival;

        $this->distance = Distance::cast($data['distance']);
        $this->max = FlightMaxValues::cast($data['max']);

        $this->fuelUsed = $data['fuel_burnt'];
        $this->geoJson = $data['geo'];
        $this->chartJson = $data['chart'];
        $this->remarks = $data['remarks'] ?? null;
        $this->tags = $data['tags'] ?? null;

    }

    /**
     * @inheritdoc
     */
    public function getFlightId(): int
    {
        return $this->id;
    }
}