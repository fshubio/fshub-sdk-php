<?php

namespace FsHub\Sdk\Entities;

use FsHub\Sdk\Types\Direction;
use FsHub\Sdk\Types\Distance;
use FsHub\Sdk\Types\LatLng;
use FsHub\Sdk\Types\Speed;
use FsHub\Sdk\Types\Wind;
use http\Header;

class FlightData
{

    /**
     * The flight ID
     * @var int
     */
    public int $id;

    /**
     * The pilot
     * @var PilotData
     */
    public PilotData $pilot;

    /**
     * The airline (optional)
     * @var AirlineData|null
     */
    public ?AirlineData $airline = null;

    /**
     * The aircraft
     * @var Aircraft
     */
    public Aircraft $aircraft;

    /**
     * The flight plan (optional)
     * @var FlightPlan|null
     */
    public ?FlightPlan $plan = null;

    /**
     * Amount of fuel burnt (in KGS)
     * @var int
     */
    public int $fuelUsed;

    /**
     * The landing rate (VSI at touchdown) in ft/min
     * @var int
     */
    public int $landingRate;

    /**
     * The total (track) distance flown
     * @var Distance
     */
    public Distance $distance;

    /**
     * Maximum statistic values
     * @var FlightMaxValues
     */
    public FlightMaxValues $max;

    /**
     * Flight time in seconds.
     * @var int
     */
    public int $time;

    /**
     * Departure details.
     * @var Transition|null
     */
    public ?Transition $departure = null;

    /**
     * Arrival details.
     * @var Transition
     */
    public Transition $arrival;

    public function fromArray(array $data)
    {

        $pilotData = new PilotData();
        $pilotData->fromArray($data['user']);

        $aircraft = new Aircraft();
        $aircraft->fromArray($data['aircraft']);
        $this->aircraft = $aircraft;

        if (isset($data['airline'])) {
            $airlineData = new AirlineData();
            $airlineData->fromArray($data['airline']);
            $this->airline = $airlineData;
        }

        if (isset($data['plan'])) {
            $planData = FlightPlan::cast($data['plan']);
            $this->plan = $planData;
        }

        $this->id = $data['id'];
        $this->pilot = $pilotData;
        $this->fuelUsed = $data['fuel_used'];
        $this->landingRate = $data['landing_rate'];
        $this->distance = Distance::cast($data['distance']);
        $this->time = $data['time'];

        $this->max = new FlightMaxValues();
        $this->max->speed = $data['max']['spd'];
        $this->max->altitude = $data['max']['alt'];

        if (isset($data['departure'])) {
            $departure = new Transition();
            $departure->icao = $data['departure']['icao'];
            $departure->iata = $data['departure']['iata'];
            $departure->name = $data['departure']['name'];

            $departure->hdg = new Direction();
            $departure->hdg->magnetic = $data['departure']['hdg']['mag'];
            $departure->hdg->true = $data['departure']['hdg']['true'];

            $departure->spd = new Speed();
            $departure->spd->tas = $data['departure']['spd']['tas'];

            $departure->geo = new LatLng();
            $departure->geo->latitude = $data['departure']['geo']['lat'];
            $departure->geo->longitude = $data['departure']['geo']['lng'];

            $departure->fuel = $data['departure']['fuel'];
            $departure->pitch = $data['departure']['pitch'];
            $departure->bank = $data['departure']['bank'];

            $departure->wind = new Wind();
            $departure->wind->direction = $data['departure']['wind']['dir'];
            $departure->wind->speed = $data['departure']['wind']['spd'];

            if (isset($data['departure']['time'])) {
                $departure->time = new \DateTime($data['departure']['time']);
            }
            $this->departure = $departure;
        }

        $arrival = new Transition();
        $arrival->icao = $data['arrival']['icao'];
        $arrival->iata = $data['arrival']['iata'];
        $arrival->name = $data['arrival']['name'];

        $arrival->hdg = new Direction();
        $arrival->hdg->magnetic = $data['arrival']['hdg']['mag'];
        $arrival->hdg->true = $data['arrival']['hdg']['true'];

        $arrival->spd = new Speed();
        $arrival->spd->tas = $data['arrival']['spd']['tas'];

        $arrival->geo = new LatLng();
        $arrival->geo->latitude = $data['arrival']['geo']['lat'];
        $arrival->geo->longitude = $data['arrival']['geo']['lng'];

        $arrival->fuel = $data['arrival']['fuel'];
        $arrival->pitch = $data['arrival']['pitch'];
        $arrival->bank = $data['arrival']['bank'];

        $arrival->wind = new Wind();
        $arrival->wind->direction = $data['arrival']['wind']['dir'];
        $arrival->wind->speed = $data['arrival']['wind']['spd'];


        if (isset($data['arrival']['time'])) {
            $arrival->time = new \DateTime($data['arrival']['time']);
        }

        $this->arrival = $arrival;
    }

}