<?php

namespace FsHub\Sdk\Entites;

use FsHub\Sdk\Types\Distance;

class FlightData
{

    public int $id;

    public PilotData $pilot;

    public ?AirlineData $airline;

    public Aircraft $aircraft;

    public ?FlightPlan $plan;

    public int $fuelUsed;

    public int $landingRate;

    public Distance $distance;

    public FlightMaxValues $max;

    public int $time;

    public ?Transistion $departure;

    public ?Transistion $arrival;

    public function fromArray(array $data)
    {
        $this->id = $data['id'];
        //$this->pilot = PilotData
//        $this->aircraft = ;
//        $this->airline = ;
//        $this->plan = ;
//        $this->fuelUsed = ;
//        $this->landingRate = ;
        $this->distance = Distance::cast($data['distance']);
        $this->time = $data['time'];
//        $this->departure = new Transistion();
//        $this->arrival = new Transistion();
    }

}